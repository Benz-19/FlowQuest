<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Client Onboarding – FlowQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CORE CSS -->
    <link rel="stylesheet" href="/css/client_onboarding.css">
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

    <script src="/js/client_onboarding.js"></script>

</body>

</html>
