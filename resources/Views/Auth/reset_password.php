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

<body class="bg-black text-white h-screen w-screen flex items-center justify-center overflow-hidden">

    <a href="/">
        <div id="logo" class="absolute top-8 left-10 text-2xl font-bold">
            FlowQuest
        </div>
    </a>

    <div class="w-full max-w-lg mt-24 md:mt-40">
        <div id="form-step" class="bg-white text-black rounded-xl shadow-lg p-8 min-h-[320px]"></div>
    </div>

    <!-- JS -->
    <script src="/js/loading_logo.js"></script>
    <script src="/js/passre.js"></script>
</body>

</html>
