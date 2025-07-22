let questions = [];
let currentStep = 0;


window.addEventListener("load", () => {
    fetch('/questions/client_onboarding.json')
        .then(res => res.json())
        .then(data => {
            questions = data; // Now steps is filled with the question
            renderStep(currentStep); // Call your existing function to start rendering
        })
        .catch(err => {
            console.error("Failed to load questions:", err);
        });
});


const responses = {};
const wrapper = document.getElementById('stepWrapper');
const nextBtn = document.getElementById('nextBtn');
const prevBtn = document.getElementById('prevBtn');
const submitBtn = document.getElementById('submitBtn');

function renderStep(index) {
    const q = questions[index];
    wrapper.innerHTML = `
            <div class="step active">
                <label class="block text-lg font-medium mb-2">${q.label}</label>
                ${q.note ? `<p class='text-sm text-red-500 mt-2'>${q.note}</p>` : ''}
                <input id="stepInput" type="${q.type}" name="${q.name}" placeholder="${q.placeholder}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-black">
                <p id="errorMessage" class="text-red-600 text-sm mt-2 hidden"></p>
            </div>
        `;
    prevBtn.style.display = index > 0 ? 'inline-block' : 'none';
    nextBtn.style.display = 'inline-block';
    submitBtn.style.display = 'none';
}

function renderReview() {
    const hiddenFields = Object.entries(responses).map(([key, value]) =>
        `<input type="hidden" name="${key}" value="${value}">`
    ).join("");

    wrapper.innerHTML = `
        <form id="finalRegisterForm" class="step active">
            <h2 class="text-xl font-bold mb-4">Review Your Info</h2>
            <ul class="space-y-2 text-sm mb-4">
                ${questions.map(q => `<li><strong>${q.label}</strong>: ${responses[q.name]}</li>`).join('')}
            </ul>
            <input type="hidden" name="user_type" value="client">
            ${hiddenFields}
            <div class="flex justify-between mt-6">
                <button type="button" onclick="prevStep()" class="bg-gray-200 px-4 py-2 rounded">Previous</button>
                <button type="submit" id="registerBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Register Now</button>
            </div>
        </form>
    `;

    nextBtn.style.display = 'none';
    prevBtn.style.display = 'none';
    submitBtn.style.display = 'none';

    // Attach submit handler to dynamically injected form
    const finalForm = document.getElementById("finalRegisterForm");
    finalForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        try {
            const formData = new URLSearchParams();
            Object.entries(responses).forEach(([key, val]) => {
                formData.append(key, val);
            });

            formData.append("is_verified", "1");
            formData.append("user_type", "client");

            // for (const [key, value] of formData.entries()) {
            //     console.log(`${key}: ${value}`); // debug what you're sending
            // }

            const register = await fetch('/api/user-register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData.toString()
            });

            const text = await register.text(); // Get plain text instead of JSON
            // console.log("RAW response:", text);

            try {
                const res = JSON.parse(text);
                if (res.status !== 200) {
                    showError("❌ Failed to register this user.");
                    return;
                }
                alert("🎉 Registration successful!");
                window.location.href = "/login";
            } catch (parseErr) {
                console.error("JSON parse error:", parseErr);
                showError("❌ Server response was not valid JSON.");
            }

        } catch (err) {
            console.error(err);
            showError("Something went wrong in registering this user.");
        }
    });
}


nextBtn.addEventListener('click', async () => {
    const input = document.getElementById('stepInput');
    const errorEl = document.getElementById('errorMessage');

    if (!input || input.value.trim() === '') {
        showError("Ensure this field is filled...");
        return;
    }

    const name = questions[currentStep].name;
    const value = input.value.trim();

    // Step: Check email uniqueness & send code
    if (currentStep === 1) {
        try {
            const res = await fetch(`/api/user-email-check?email=${encodeURIComponent(value)}&user_type=client`);
            const text = await res.text();
            const data = JSON.parse(text);

            if (data.exists) {
                showError("❌ This email already exists. Try another one.");
                return;
            }

            const send = await fetch('/api/send-verification-code?send_code=true', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `email=${encodeURIComponent(value)}&name=${encodeURIComponent(responses.name)}`
            });

            const sent = await send.json();

            if (sent.status !== 200) {
                showError("Failed to send verification email. Try again later.");
                return;
            }

            responses[name] = value;
            currentStep++;
            renderStep(currentStep);
            return;

        } catch (err) {
            showError("Network/server error. Try again later.");
            return;
        }
    }

    // Step: Verify code
    if (questions[currentStep].isCodeStep) {
        try {
            const verify = await fetch('/api/verify-code?verify_code=true', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `email=${encodeURIComponent(responses.email)}&code=${encodeURIComponent(value)}&verify_code=true`
            });

            const result = await verify.json();
            // console.log(result);
            if (!result.valid) {
                showError("Incorrect code. Failed to verify your email.");
                return;
            }

        } catch (err) {
            showError("Verification failed. Try again.");
            return;
        }
    }

    responses[name] = value;
    currentStep++;
    if (currentStep < questions.length) {
        renderStep(currentStep);
    } else {
        renderReview();
    }
});

prevBtn.addEventListener('click', () => {
    if (currentStep === questions.length) {
        currentStep--;
        renderStep(currentStep);
    } else if (currentStep > 0) {
        currentStep--;
        renderStep(currentStep);
    }
});

function showError(message) {
    const errorEl = document.getElementById('errorMessage');
    if (!errorEl) return;
    errorEl.textContent = message;
    errorEl.classList.remove('hidden');
    setTimeout(() => {
        errorEl.classList.add('hidden');
        errorEl.textContent = '';
    }, 6000);
}

