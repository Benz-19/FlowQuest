<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
    <title>Who Are You? – FlowQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', 'Lucida Grande', sans-serif;
        }

        #logo {
            transform: translateX(-100%);
            transition: transform 1s ease;
        }

        #logo.slide-in {
            transform: translateX(0);
            opacity: 1;
        }
    </style>
</head>

<body class="bg-black text-white min-h-screen flex flex-col items-center justify-start pt-12 px-4">

    <a href="/">
        <div id="logo" class="absolute top-8 left-6 text-2xl sm:text-3xl font-bold">FlowQuest</div>
    </a>
    <div class="text-center mt-24">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Who Are You?</h1>
        <p class="text-gray-400 text-sm sm:text-base md:text-lg max-w-md mx-auto">
            Let’s personalize your experience. Tell us who you are so we can serve you better.
        </p>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
        <!-- Freelancer Card -->
        <div onclick="location.href='/register-freelancer'"
            class="cursor-pointer bg-white text-black rounded-xl shadow-lg p-8 flex flex-col items-center transition-transform duration-300 hover:-translate-y-2">
            <img src="/images/freelancer.png" alt="Freelancer" loading="lazy" class="w-24 h-24 mb-4">
            <h3 class="text-xl sm:text-2xl font-bold mb-2">I'm a Freelancer</h3>
            <p class="text-gray-600 text-center text-sm sm:text-base">Create and manage invoices, subscriptions, clients, and more from your powerful dashboard.</p>
        </div>

        <!-- Client Card -->
        <div onclick="location.href='/register-client'"
            class="cursor-pointer bg-white text-black rounded-xl shadow-lg p-8 flex flex-col items-center transition-transform duration-300 hover:-translate-y-2">
            <img src="/images/client.png" alt="Client" loading="lazy" class="w-24 h-24 mb-4">
            <h3 class="text-xl sm:text-2xl font-bold mb-2">I'm a Client</h3>
            <p class="text-gray-600 text-center text-sm sm:text-base">View invoices, manage your subscriptions, and keep up with payments in a single place.</p>
        </div>
    </div>

    <!-- JS -->
    <script src="/js/loading_logo.js"></script>
</body>

</html>
