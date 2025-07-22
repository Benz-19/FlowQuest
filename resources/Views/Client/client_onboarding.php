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

    <script src="/js/client_onloading.js"></script>

</body>

</html>
