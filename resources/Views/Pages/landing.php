<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FlowQuest – The Future of Subscription Billing</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@heroicons/react/24/outline"></script>

    <style>
        body {
            font-family: 'Roboto', 'Lucida Sans', sans-serif;
        }

        .card-set {
            transition: all 1s ease-in-out;
            opacity: 0;
            transform: rotate(-5deg) scale(0.95);
        }

        .card-set.active {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        .card-set .card {
            transition: transform 0.6s ease;
            transform-origin: center center;
            height: 380px;
        }

        .card-set.active .card:nth-child(1) {
            transform: translateX(-160px) rotate(-10deg);
            transition-delay: 0.1s;
        }

        .card-set.active .card:nth-child(2) {
            transform: translateX(-50px) rotate(-3deg);
            transition-delay: 0.2s;
        }

        .card-set.active .card:nth-child(3) {
            transform: translateX(50px) rotate(3deg);
            transition-delay: 0.3s;
        }

        .card-set.active .card:nth-child(4) {
            transform: translateX(160px) rotate(10deg);
            transition-delay: 0.4s;
        }

        .glow {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.6);
            }

            50% {
                box-shadow: 0 0 0 12px rgba(255, 255, 255, 0);
            }
        }

        .contact-card:hover {
            transform: translateY(-8px);
            transition: transform 0.3s ease;
        }

        .frosted-bar {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.15);
            width: 4px;
            height: 60px;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-black text-white">

    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-6">
        <h1 class="text-3xl font-bold hover:text-gray-400 transition"><a href="/">FlowQuest</a></h1>
        <nav class="space-x-6 text-sm text-gray-300">
            <a href="#features" class="hover:underline">Features</a>
            <a href="#cards" class="hover:underline">Tools</a>
            <a href="#contact" class="hover:underline">Contact</a>
            <a href="/login" class="bg-white text-black px-4 py-2 rounded hover:bg-gray-200 transition">Login</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-[30vh] px-6">
        <h2 class="text-7xl md:text-8xl font-extrabold mb-8">Smarter Subscriptions for Modern Businesses</h2>
        <p class="text-2xl max-w-5xl mx-auto text-gray-400 leading-relaxed">
            FlowQuest automates invoicing, manages recurring payments, and empowers your clients with sleek, intuitive tools — all in one futuristic dashboard.
        </p>
        <div class="mt-16">
            <a href="#" class="glow bg-white text-black text-xl px-10 py-5 rounded-lg hover:bg-gray-200 transition">Get Started</a>
        </div>
    </section>

    <!-- Cards Section -->
    <section id="cards" class="py-[25vh] bg-white text-black">
        <div class="text-center mb-20">
            <h3 class="text-5xl font-bold mb-4">Your Business Tools</h3>
            <p class="text-gray-600 text-lg">Stacked like a winning hand, revealed with every scroll.</p>
        </div>
        <div class="flex justify-center items-center">
            <div id="card-set" class="card-set relative w-[600px] h-[500px]">
                <div class="card absolute top-0 left-0 bg-black text-white rounded-2xl p-10 shadow-2xl w-full text-lg font-semibold z-10">
                    💳 Auto-Billing
                    <p class="mt-3 text-sm text-gray-300">Automatically send invoices, charge cards, notify users in real-time, retry failed payments, and maintain up-to-date records — without lifting a finger.</p>
                </div>
                <div class="card absolute top-0 left-0 bg-black text-white rounded-2xl p-10 shadow-2xl w-full text-lg font-semibold z-20">
                    📅 Client Portal
                    <p class="mt-3 text-sm text-gray-300">Let your clients view billing history, download receipts, manage subscriptions, raise tickets, and communicate with support — all from a beautiful interface.</p>
                </div>
                <div class="card absolute top-0 left-0 bg-black text-white rounded-2xl p-10 shadow-2xl w-full text-lg font-semibold z-30">
                    🔁 Recurring Plans
                    <p class="mt-3 text-sm text-gray-300">Create unlimited subscription plans tailored to your business model. Offer trials, discounts, billing cycles, and renewals with powerful recurring logic.</p>
                </div>
                <div class="card absolute top-0 left-0 bg-black text-white rounded-2xl p-10 shadow-2xl w-full text-lg font-semibold z-40">
                    📈 Insights
                    <p class="mt-3 text-sm text-gray-300">Visualize metrics like growth, churn, MRR, and lifetime value. Understand what works and pivot with real-time analytics powering your decisions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-[25vh] px-6 bg-black text-white">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-16 text-center items-center">
            <div>
                <h4 class="text-2xl font-bold mb-3">Endless Customization</h4>
                <p class="text-gray-400">Design and deliver invoices exactly how your brand demands.</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="flex gap-3 mb-4">
                    <div class="frosted-bar"></div>
                    <div class="frosted-bar"></div>
                </div>
                <div>
                    <h4 class="text-2xl font-bold mb-3">Secure & Scalable</h4>
                    <p class="text-gray-400">Built with encryption, performance, and growth in mind.</p>
                </div>
                <div class="flex gap-3 mt-4">
                    <div class="frosted-bar"></div>
                    <div class="frosted-bar"></div>
                </div>
            </div>
            <div>
                <h4 class="text-2xl font-bold mb-3">Fast Integrations</h4>
                <p class="text-gray-400">Integrate with your stack in minutes using our clean API.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-[25vh] px-6 bg-white text-black">
        <div class="max-w-2xl mx-auto text-center mb-16">
            <h3 class="text-5xl font-bold mb-4">Contact Us</h3>
            <p class="text-gray-600 text-lg">Got questions? Reach out and we'll get back in a flash.</p>
        </div>
        <div class="max-w-xl mx-auto bg-white p-10 rounded-xl shadow-[0_0_80px_rgba(0,0,0,0.15)] contact-card">
            <form class="space-y-6">
                <div>
                    <input type="text" placeholder="Your Name" class="w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black transition" />
                </div>
                <div>
                    <input type="email" placeholder="Your Email" class="w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black transition" />
                </div>
                <div>
                    <textarea rows="5" placeholder="Your Message" class="w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black transition"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-black text-white px-8 py-4 rounded-md hover:bg-gray-800 transition">Send Message</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="flex flex-col md:flex-row items-center justify-between py-12 px-6 text-sm text-gray-500 bg-black border-t border-gray-700">
        <div class="mb-4 md:mb-0 font-bold">FlowQuest</div>
        <div class="space-x-6 flex">
            <a href="https://linkedin.com" class="hover:text-white" target="_blank" aria-label="LinkedIn">🔗</a>
            <a href="https://twitter.com" class="hover:text-white" target="_blank" aria-label="Twitter">🔗</a>
            <a href="https://github.com" class="hover:text-white" target="_blank" aria-label="GitHub">🔗</a>
            <a href="mailto:hello@flowquest.com" class="hover:text-white" aria-label="Email">📧</a>
        </div>
    </footer>

    <!-- Scroll Animation Script -->
    <script>
        const cardSet = document.getElementById("card-set");
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    cardSet.classList.add("active");
                } else {
                    cardSet.classList.remove("active");
                }
            });
        }, {
            threshold: 0.5
        });
        observer.observe(cardSet);
    </script>
</body>

</html>
