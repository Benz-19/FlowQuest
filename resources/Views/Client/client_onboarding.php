<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Client Onboarding – FlowQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', 'Lucida Grande', sans-serif;
        }

        .step {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-in-out;
        }

        .step.active {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-in {
            animation: slideIn 1s ease forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }


        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #000;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-black text-white min-h-screen w-screen flex flex-col items-center px-6 overflow-hidden pt-6">

    <header class="absolute top-6 left-6 text-2xl font-bold">
        <a href="/">
            <h1 class="text-3xl md:text-4xl font-bold mb-10 slide-in">FlowQuest</h1>
        </a>
    </header>

    <main class="w-full max-w-lg mt-24 md:mt-40">
        <div id="formContainer" class="p-8 bg-white text-black rounded-xl shadow-2xl">
            <div id="stepWrapper"></div>

            <div class="flex justify-between mt-6">
                <button id="prevBtn" class="bg-gray-200 px-4 py-2 rounded hidden">Previous</button>
                <button id="nextBtn" class="bg-black text-white px-4 py-2 rounded">Next</button>
                <button id="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded hidden">Register Now</button>
            </div>
        </div>
    </main>

    <script>
        const questions = [{
                label: "What's your full name?",
                name: "name",
                type: "text",
                placeholder: "John Doe"
            },
            {
                label: "What's your work email?",
                name: "email",
                type: "email",
                note: "*Must be a valid work email",
                placeholder: "john@company.com"
            },
            {
                label: "Create a password",
                name: "password",
                type: "password",
                placeholder: "••••••••"
            },
            {
                label: "Your company name (optional)",
                name: "company",
                type: "text",
                placeholder: "Company Inc."
            },
            {
                label: "What service are you looking for?",
                name: "service",
                type: "text",
                placeholder: "e.g. Accounting, Web Development..."
            },
        ];

        let currentStep = 0;
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
            <input id="stepInput" type="${q.type}" name="${q.name}" placeholder="${q.placeholder}"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-black">
            <p id="errorMessage" class="text-red-600 text-sm mt-2 hidden"></p>
        </div>
    `;
            prevBtn.style.display = index > 0 ? 'inline-block' : 'none';
            nextBtn.style.display = 'inline-block';
            submitBtn.style.display = 'none';
        }


        function renderReview() {
            const hiddenFields = Object.entries(responses).map(([key, value]) => `
            <input type="hidden" name="${key}" value="${value}">
        `).join("");

            wrapper.innerHTML = `
            <form action="/process-registration" method="POST" class="step active">
                <h2 class="text-xl font-bold mb-4">Review Your Info</h2>
                <ul class="space-y-2 text-sm mb-4">
                    ${questions.map(q => `<li><strong>${q.label}</strong>: ${responses[q.name]}</li>`).join('')}
                </ul>

                <input type="hidden" name="user_type" value="client">
                ${hiddenFields}

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep()" class="bg-gray-200 px-4 py-2 rounded">Previous</button>
                    <button type="submit" name="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Register Now</button>
                </div>
            </form>
        `;

            nextBtn.style.display = 'none';
            prevBtn.style.display = 'none';
            submitBtn.style.display = 'none';
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

            // Email uniqueness check
            if (currentStep === 1) {
                const loader = document.createElement('div');
                loader.id = 'loader';
                loader.innerHTML = `
            <div class="flex items-center mt-2 text-sm">
                <svg class="animate-spin mr-2 h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                Checking email...
            </div>
        `;
                wrapper.appendChild(loader);

                try {
                    const res = await fetch(`/api/user-email-check?email=${encodeURIComponent(value)}&user_type=client`);
                    const data = await res.json();
                    document.getElementById('loader')?.remove();

                    if (data.exists) {
                        showError("❌ This email already exists. Try another one.");
                        return;
                    }
                } catch (err) {
                    showError("Server error while checking email. Try again later.");
                    document.getElementById('loader')?.remove();
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

            // Hide after 6 seconds
            setTimeout(() => {
                errorEl.classList.add('hidden');
                errorEl.textContent = '';
            }, 6000);
        }


        renderStep(currentStep);
    </script>

</body>

</html>
