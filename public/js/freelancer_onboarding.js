window.addEventListener("load", () => {
    renderStep();
});

let steps = [];

window.addEventListener("load", () => {
    fetch('/questions/freelancer_onboarding.json')
        .then(res => res.json())
        .then(data => {
            steps = data;       // Now steps is filled with the questions
            renderStep();       // render steps after loading the questions
        })
        .catch(err => {
            console.error("Failed to load questions:", err);
        });
});


let currentStep = 0;
const answers = {};

const renderStep = () => {
    const container = document.getElementById("form-step");
    const step = steps[currentStep];

    container.innerHTML = `
    <div class="fade-card" id="animated-step">
        <h2 class="text-xl font-semibold mb-4">${step.icon} ${step.question}</h2>
        ${step.hint ? `<p class="text-sm text-red-600 mb-2">${step.hint}</p>` : ''}
        ${step.isExperienceQuestion ? `
            <div class="text-sm text-blue-600 mb-2">
                Use only numbers: 1 - Beginner, 2 - Intermediate, 3 - Expert
            </div>` : ''}
        <input type="${step.type}" id="inputField" name="${step.name}" placeholder="${step.placeholder}" class="w-full px-4 py-2 border rounded focus:outline-none mb-2" />

        <p id="errorMessage" class="text-sm text-red-500 mt-1 mb-3 hidden"></p>

        <div class="flex justify-between mt-6">
            ${currentStep > 0 ? `<button onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Previous</button>` : "<span></span>"}
            <button onclick="nextStep()" id="nextBtn" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
                ${currentStep === steps.length - 1 ? "Review" : "Next"}
            </button>
        </div>
    </div>
    `;

    requestAnimationFrame(() => {
        document.getElementById("animated-step").classList.add("show");
    });
};


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
    if (stepName === "email") {
        container.innerHTML += `<div id="loader" class="flex items-center mt-4"><div class="loader mr-2"></div><p class="text-sm">Checking email...</p></div>`;
        try {
            const res = await fetch(`/api/user-email-check?email=${encodeURIComponent(stepValue)}&user_type=freelancer`);
            const data = await res.json();
            document.getElementById("loader").remove();

            if (data.exists) {
                showError("This email already exists. Try another one.");
                return;
            }

            const send = await fetch('/api/send-verification-code?send_code=true', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(stepValue)}&name=${encodeURIComponent(answers.name || '')}`
            });

            const sent = await send.json();
            if (sent.status !== 200) {
                showError("Failed to send verification email.");
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
            if (!result.valid) {
                showError("Incorrect code.");
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
        renderStep();
    } else {
        renderReview();
    }
};

const prevStep = () => {
    if (currentStep > 0) {
        currentStep--;
        renderStep();
    }
};

const renderReview = () => {
    const container = document.getElementById("form-step");

    const listItems = Object.entries(answers).map(([key, value]) => `
            <li class="mb-2"><strong class="capitalize">${key}:</strong> ${key === "password" ? "••••••••" : value}</li>
        `).join("");

    container.innerHTML = `
        <form id="finalFreelancerForm" class="fade-card show">
            <h2 class="text-xl font-semibold mb-4">Review Your Information</h2>
            <ul class="mb-6">${listItems}</ul>
            <input type="hidden" name="user_type" value="freelancer">
            ${Object.entries(answers).map(([k, v]) => `<input type="hidden" name="${k}" value="${v}">`).join("")}
            <div class="flex justify-between">
                <button type="button" onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Previous</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Register Now</button>
            </div>
        </form>
        `;

    document.getElementById("finalFreelancerForm").addEventListener("submit", async function (e) {
        e.preventDefault();

        try {
            const formData = new URLSearchParams();
            Object.entries(answers).forEach(([key, val]) => formData.append(key, val));
            formData.append("is_verified", "1");
            formData.append("user_type", "freelancer");

            const register = await fetch('/api/user-register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });

            const text = await register.text();
            try {
                const res = JSON.parse(text);
                if (res.status !== 200) {
                    showError("Registration failed.");
                    return;
                }
                alert("🎉 Registration successful!");
                window.location.href = "/login";
            } catch (parseErr) {
                console.error("Invalid JSON:", parseErr);
                showError("Server sent invalid response.");
            }

        } catch (err) {
            console.error(err);
            showError("Something went wrong.");
        }
    });
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
