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
    </style>
</head>

<body class="bg-black text-white min-h-screen flex flex-col items-center justify-center p-6 overflow-x-hidden">

    <div id="logo" class="absolute top-6 left-6 text-2xl font-bold">
        FlowQuest
    </div>

    <div class="w-full max-w-lg mt-24 md:mt-40">
        <div id="form-step" class="bg-white text-black rounded-xl shadow-lg p-8 min-h-[320px]"></div>
    </div>

    <script>
        window.addEventListener("load", () => {
            document.getElementById("logo").classList.add("slide-in");
            renderStep();
        });

        const steps = [{
                question: "What’s your full name?",
                name: "name",
                placeholder: "John Doe",
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
                placeholder: "e.g. UI/UX, Web Dev, Marketing",
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
            placeholder="${step.placeholder}" class="w-full px-4 py-2 border rounded focus:outline-none mb-4" />

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

        const nextStep = () => {
            const field = document.getElementById("inputField");
            if (!field.value.trim()) return alert("Please complete the field before continuing.");
            answers[steps[currentStep].name] = field.value.trim();

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

            container.innerHTML = `
        <div class="fade-card show">
          <h2 class="text-xl font-semibold mb-4">Review Your Information</h2>
          <ul class="mb-6">${listItems}</ul>

          <div class="flex justify-between">
            <button onclick="prevStep()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Previous</button>
            <button onclick="registerUser()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
              Register Now
            </button>
          </div>
        </div>
      `;
        };

        const registerUser = () => {
            console.log("Registering with data:", answers);
            alert("✅ Registration submitted!\n(See console for submitted data.)");
        };
    </script>
</body>

</html>
