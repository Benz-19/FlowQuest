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
            <input id="stepInput" type="${q.type}" name="${q.name}" placeholder="${q.placeholder}"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-black">
            ${q.note ? `<p class='text-sm text-red-500 mt-2'>${q.note}</p>` : ''}
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


        nextBtn.addEventListener('click', () => {
            const input = document.getElementById('stepInput');
            if (input && input.value.trim() !== '') {
                responses[questions[currentStep].name] = input.value.trim();
                currentStep++;
                if (currentStep < questions.length) {
                    renderStep(currentStep);
                } else {
                    renderReview();
                }
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

        renderStep(currentStep);
    </script>

</body>

</html>
