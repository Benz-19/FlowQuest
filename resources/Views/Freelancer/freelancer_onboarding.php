<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
    <title>Freelancer Onboarding – FlowQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', 'Lucida Grande', sans-serif;
        }

        .fade-card {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.5s ease-in-out;
        }

        .fade-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        #logo {
            transform: translateX(-100%);
            transition: transform 1s ease;
        }

        #logo.slide-in {
            transform: translateX(0);
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

<body class="bg-black text-white min-h-screen flex flex-col items-center justify-center p-6 overflow-x-hidden">

    <a href="/">
        <div id="logo" class="absolute top-6 left-6 text-2xl font-bold">
            FlowQuest
        </div>
    </a>

    <div class="w-full max-w-lg mt-24 md:mt-40">
        <div id="form-step" class="bg-white text-black rounded-xl shadow-lg p-8 min-h-[320px]"></div>
    </div>

    <!-- JS -->
    <script src="/js/loading_logo.js"></script>
    <script>
        window.addEventListener("load", () => {
            renderStep();
        });

        const steps = [{
                question: "What’s your full name?",
                name: "name",
                placeholder: "Johnny Test",
                type: "text",
                icon: "👤"
            },
            {
                question: "What’s your work email?",
                name: "email",
                placeholder: "name@company.com",
                type: "email",
                icon: "📧",
                hint: "Use your work email"
            },
            {
                question: "Create a secure password",
                name: "password",
                placeholder: "••••••••",
                type: "password",
                icon: "🔒"
            },
            {
                question: "What services do you offer?",
                name: "services",
                placeholder: "e.g. UI/UX, Web Dev, Marketing, Catering",
                type: "text",
                icon: "🛠"
            },
            {
                question: "What’s your business name?",
                name: "business",
                placeholder: "Optional – FlowQuest Studios",
                type: "text",
                icon: "🏢"
            },
            {
                question: "How experienced are you?",
                name: "experience",
                placeholder: "Beginner, Intermediate, Expert",
                type: "text",
                icon: "📈"
            },
        ];

        let currentStep = 0;
        const answers = {};

        const renderStep = () => {
            const container = document.getElementById("form-step");
            const step = steps[currentStep];

            container.innerHTML = `
            <div class="fade-card" id="animated-step">
                <h2 class="text-xl font-semibold mb-4">${step.icon} ${step.question}</h2>
                ${step.hint ? `<p class="text-sm text-red-600 mb-2">${step.hint}</p>` : ''}
                <input type="${step.type}" id="inputField" name="${step.name}"
                placeholder="${step.placeholder}" class="w-full px-4 py-2 border rounded focus:outline-none mb-2" />

                <p id="errorMessage" class="text-sm text-red-500 mt-1 mb-3 hidden"></p>

                <div class="flex justify-between mt-6">
                ${currentStep > 0
                    ? `<button onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Previous</button>`
                    : "<span></span>"
                }
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
                alert("Please complete the field before continuing.");
                return;
            }

            const stepName = steps[currentStep].name;
            const stepValue = field.value.trim();

            // Show loader if it's the email step
            if (stepName === "email") {
                container.innerHTML += `
            <div id="loader" class="flex items-center mt-4">
                <div class="loader mr-2"></div>
                <p class="text-sm">Checking email...</p>
            </div>
            `;

                try {
                    const res = await fetch(`/api/user-email-check?email=${encodeURIComponent(stepValue)}&user_type=freelancer`);
                    const data = await res.json();
                    document.getElementById("loader").remove();

                    if (data.exists) {
                        const errorEl = document.getElementById("errorMessage");
                        if (errorEl) {
                            errorEl.textContent = "❌ This email already exists. Try another one.";
                            errorEl.classList.remove("hidden");
                        }
                        return;
                    }
                } catch (error) {
                    alert("Server error while checking email. Try again later.");
                    document.getElementById("loader").remove();
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
            <li class="mb-2">
                <strong class="capitalize">${key}:</strong> ${key === "password" ? "••••••••" : value}
            </li>
            `).join("");

            // Hidden input fields to submit collected data
            const hiddenFields = Object.entries(answers).map(([key, value]) => `
            <input type="hidden" name="${key}" value="${value}">
            `).join("");

            container.innerHTML = `
            <form action="/process-registration" method="POST" class="fade-card show">
                <h2 class="text-xl font-semibold mb-4">Review Your Information</h2>
                <ul class="mb-6">${listItems}</ul>

                <input type="hidden" name="user_type" value="freelancer">
                ${hiddenFields}

                <div class="flex justify-between">
                <button type="button" onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Previous
                </button>
                <button type="submit" name="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Register Now
                </button>
                </div>
            </form>
            `;
        };

        const registerUser = () => {
            console.log("Registering with data:", answers);
            alert("✅ Registration submitted!\n(See console for submitted data.)");
        };
    </script>
</body>

</html>
