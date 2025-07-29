window.addEventListener('load', () => {
    renderSteps();
});

let steps = [];

window.addEventListener('load', () => {
    fetch('/questions/password_reset.json')
        .then(response => response.json())
        .then(data => {
            steps = data;
            renderSteps();
        })
        .catch(error => {
            console.error("Faoled to load the questions", error);
        })
});

let currentStep = 0;
const answers = {};

const renderSteps = () => {
    const container = document.getElementById("form-step");
    const step = steps[currentStep];

    container.innerHTML = `
    <div class="fade-card" id="animated-step">
        <h2 class="text-xl font-semibold mb-4">${step.icon} ${step.title}</h2>
        ${step.label ? `<p class="text-sm text-red-600 mb-2">${step.label}</p>` : ''}

        <input type="${step.type}" id="inputField" name="${step.name}" placeholder="${step.placeholder}" class="w-full px-4 py-2 border rounded focus:outline-none mb-2 italic::placeholder" />

        <p id="errorMessage" class="text-sm text-red-500 mt-1 mb-3 hidden"></p>
        ${step.hasAccount ? ` <p class="text-center text-sm text-gray-600 mt-6">
            Already have an account?
            <a href="/login"
                class="text-blue-600 hover:underline inline-block transition-transform duration-300 hover:translate-x-1 hover:text-gray-800">
                Login
            </a>
        </p>` : ''}
        <div class="flex justify-between mt-6">
            ${currentStep > 0 ? `<button onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Previous</button>` : "<span></span>"}
            <button onclick="nextStep()" id="nextBtn" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
                ${currentStep === steps.length - 1 ? "Review" : "Next"}
            </button>
        </div>
    </div>
    `;
}



const nextStep = async () => {
    const field = document.getElementById("inputField");
    const container = document.getElementById("form-step");

    if (!field.value.trim()) {
        showError("Please complete the field before continuing.");
        return;
    }

    const stepName = steps[currentStep].name;
    const stepValue = field.value.trim();

    // Step 2: Email check & send code
    if (stepName === "Email") {
        container.innerHTML += `<div id="loader" class="flex items-center mt-4"><div class="loader mr-2"></div><p class="text-sm">Checking email...</p></div>`;
        try {

            document.getElementById("loader").remove();

            const send = await fetch('/api/send-password-reset-verification-code?send_code=true', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(stepValue)}&name=${encodeURIComponent(answers.name || '')}`
            });

            const sent = await send.json();
            if (sent.status !== 200) {
                showError("❌ Failed to send verification email.");
                return;
            }

        } catch (error) {
            showError("Server error. Try again.");
            return;
        }
    }

    // Step 3: Verify code
    if (steps[currentStep].isCodeStep) {
        try {
            const verify = await fetch('/api/verify-code?verify_code=true', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(answers.email)}&code=${encodeURIComponent(stepValue)}`
            });

            const result = await verify.json();
            console.log('The code = ', result);
            if (!result.valid) {
                showError("❌ Incorrect code.");
                return;
            }

        } catch (err) {
            showError("Verification failed. Try again.");
            return;
        }
    }

    answers[stepName] = stepValue;

    if (currentStep < steps.length - 1) {
        currentStep++;
        renderSteps();
    } else {
        renderReview();
    }
};

const prevStep = () => {
    if (currentStep > 0) {
        currentStep--;
        renderSteps();
    }
};

function showError(message) {
    const errorEl = document.getElementById("errorMessage");
    if (!errorEl) return;
    errorEl.textContent = message;
    errorEl.classList.remove("hidden");
    setTimeout(() => {
        errorEl.classList.add("hidden");
        errorEl.textContent = '';
    }, 6000);
}
