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
    <script src="/js/freelancer_onboarding.js"></script>
</body>

</html>
