<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/images/logo.png" type="image/x-icon">
    <title>Password Reset – FlowQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', 'Lucida Grande', sans-serif;
        }

        .slide-up {
            transform: translateY(100%);
            opacity: 0;
            transition: all 1s ease;
        }

        .slide-up.visible {
            transform: translateY(0);
            opacity: 1;
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

<body class="bg-black text-white h-screen w-screen flex items-center justify-center overflow-hidden">

    <a href="/">
        <div id="logo" class="absolute top-8 left-10 text-2xl font-bold">
            FlowQuest
        </div>
    </a>

    <div id="loginCard" class="slide-up w-full max-w-md p-8 bg-white text-black rounded-xl shadow-2xl">
        <h2 class="text-2xl font-semibold mb-2 text-center">Password Reset</h2>
        <p class="text-sm text-center text-gray-800 mb-6">Provide your FlowQuest email address</p>

        <form action="/process-login" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2">Email</label>
                <input type="email" placeholder="you@example.com" name="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
            </div>
            <!-- <div class="mb-6">
                <label class="block text-gray-700 text-sm mb-2">Password</label>
                <input type="password" placeholder="••••••••" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-gray-300">
            </div> -->

            <button type="submit" name="nextBtn"
                class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition duration-300">
                Send Code
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Already have an account?
            <a href="/login"
                class="text-blue-600 hover:underline inline-block transition-transform duration-300 hover:translate-x-1 hover:text-gray-800">
                Login
            </a>
        </p>
    </div>

    <!-- JS -->
    <script src="/js/loading_logo.js"></script>
    <script>
        window.addEventListener('load', () => {
            document.getElementById('loginCard').classList.add('visible');
        });
    </script>
</body>

</html>
