<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FlowQuest — Smart Invoice & Subscription System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom animations similar to Revolut */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hover effect on buttons */
        .btn-primary:hover {
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .btn-secondary:hover {
            background: #3b82f6;
            color: white;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-indigo-900 via-purple-900 to-indigo-800 text-white font-sans">

    <!-- Header / Navbar -->
    <header class="fixed w-full bg-indigo-900/80 backdrop-blur-md z-50">
        <nav class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6 md:px-12">
            <div class="text-3xl font-extrabold tracking-wide cursor-pointer select-none">FlowQuest</div>
            <ul class="hidden md:flex space-x-8 text-lg font-semibold">
                <li><a href="#features" class="hover:text-indigo-300 transition">Features</a></li>
                <li><a href="#how" class="hover:text-indigo-300 transition">How it Works</a></li>
                <li><a href="#pricing" class="hover:text-indigo-300 transition">Pricing</a></li>
                <li><a href="#contact" class="hover:text-indigo-300 transition">Contact</a></li>
            </ul>
            <div class="hidden md:flex space-x-4">
                <a href="#" class="btn-secondary px-4 py-2 rounded-md font-semibold cursor-pointer border border-indigo-500 hover:bg-indigo-600">Log in</a>
                <a href="#" class="btn-primary bg-indigo-600 px-5 py-2 rounded-md font-semibold cursor-pointer text-white">Get Started</a>
            </div>
            <!-- Mobile hamburger -->
            <div id="mobile-menu-button" class="md:hidden cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                </svg>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden bg-indigo-900/95 backdrop-blur-md px-6 pb-6 md:hidden">
            <ul class="flex flex-col space-y-4 text-lg font-semibold pt-4">
                <li><a href="#features" class="hover:text-indigo-300 transition">Features</a></li>
                <li><a href="#how" class="hover:text-indigo-300 transition">How it Works</a></li>
                <li><a href="#pricing" class="hover:text-indigo-300 transition">Pricing</a></li>
                <li><a href="#contact" class="hover:text-indigo-300 transition">Contact</a></li>
                <li class="pt-4 flex space-x-4">
                    <a href="#" class="btn-secondary px-4 py-2 rounded-md font-semibold cursor-pointer border border-indigo-500 hover:bg-indigo-600 w-full text-center">Log in</a>
                    <a href="#" class="btn-primary bg-indigo-600 px-5 py-2 rounded-md font-semibold cursor-pointer text-white w-full text-center">Get Started</a>
                </li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="min-h-screen flex flex-col md:flex-row items-center justify-center max-w-7xl mx-auto px-6 md:px-12 pt-24 md:pt-32 gap-12">
        <!-- Left side text -->
        <div class="flex-1 text-center md:text-left space-y-6 fade-in">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight max-w-xl">
                Smart Invoicing.<br />
                Automated Subscriptions.<br />
                <span class="text-indigo-400">Built for Freelancers & Agencies.</span>
            </h1>
            <p class="text-indigo-300 text-lg max-w-lg">
                FlowQuest helps you create, manage, and automate your invoicing process seamlessly.
                Save time, get paid faster, and focus on your craft.
            </p>
            <div class="space-x-4 mt-6">
                <a href="#" class="btn-primary bg-indigo-600 px-6 py-3 rounded-md font-semibold cursor-pointer text-white inline-block">Try FlowQuest</a>
                <a href="#" class="btn-secondary border border-indigo-500 px-6 py-3 rounded-md font-semibold cursor-pointer inline-block">Watch Demo</a>
            </div>
        </div>

        <!-- Right side animation placeholder -->
        <div class="flex-1 relative w-full max-w-lg h-96 bg-gradient-to-tr from-indigo-700 via-purple-800 to-indigo-900 rounded-xl shadow-2xl overflow-hidden fade-in">
            <!-- Placeholder for animated SVG or Lottie -->
            <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <rect x="0" y="0" width="400" height="300" rx="24" ry="24" fill="url(#gradient)" />
                <circle cx="200" cy="150" r="90" stroke="white" stroke-width="3" />
                <path stroke="white" stroke-width="2" d="M120 150c20-40 80-40 100 0" />
                <path stroke="white" stroke-width="2" d="M170 100v100" />
                <path stroke="white" stroke-width="2" d="M230 100v100" />
                <defs>
                    <linearGradient id="gradient" x1="0" y1="0" x2="400" y2="300">
                        <stop offset="0%" stop-color="#4f46e5" />
                        <stop offset="100%" stop-color="#3b82f6" />
                    </linearGradient>
                </defs>
            </svg>
            <div class="absolute bottom-6 left-6 text-indigo-300 text-sm font-mono">Animated invoice preview (placeholder)</div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="max-w-7xl mx-auto px-6 md:px-12 py-24 grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="fade-in rounded-xl bg-indigo-800 p-8 shadow-lg flex flex-col items-center text-center space-y-4 hover:scale-105 transition-transform cursor-default">
            <svg class="w-12 h-12 mb-2 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6 4H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 002 2z" />
            </svg>
            <h3 class="text-xl font-semibold">Generate Beautiful Invoices</h3>
            <p class="text-indigo-300">Create professional invoices with customizable items, taxes, and totals.</p>
        </div>
        <div class="fade-in rounded-xl bg-indigo-800 p-8 shadow-lg flex flex-col items-center text-center space-y-4 hover:scale-105 transition-transform cursor-default">
            <svg class="w-12 h-12 mb-2 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <h3 class="text-xl font-semibold">Automated Subscriptions</h3>
            <p class="text-indigo-300">Set up recurring invoices and manage subscriptions easily.</p>
        </div>
        <div class="fade-in rounded-xl bg-indigo-800 p-8 shadow-lg flex flex-col items-center text-center space-y-4 hover:scale-105 transition-transform cursor-default">
            <svg class="w-12 h-12 mb-2 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h8m-8 4h6" />
            </svg>
            <h3 class="text-xl font-semibold">Client Management</h3>
            <p class="text-indigo-300">Keep all client data, payments, and invoices organized in one place.</p>
        </div>
    </section>

    <!-- How it works Section -->
    <section id="how" class="bg-indigo-900 py-20 px-6 md:px-12 max-w-7xl mx-auto text-center space-y-12">
        <h2 class="text-4xl font-extrabold max-w-3xl mx-auto fade-in">How FlowQuest Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 max-w-5xl mx-auto">
            <div class="fade-in space-y-4">
                <div class="mx-auto w-20 h-20 rounded-full bg-indigo-700 flex items-center justify-center text-indigo-300 font-bold text-2xl select-none">1</div>
                <h3 class="text-xl font-semibold">Connect Your Accounts</h3>
                <p class="text-indigo-300 max-w-sm mx-auto">Securely link your bank and payment accounts to FlowQuest to track transactions and payments automatically.</p>
            </div>
            <div class="fade-in space-y-4">
                <div class="mx-auto w-20 h-20 rounded-full bg-indigo-700 flex items-center justify-center text-indigo-300 font-bold text-2xl select-none">2</div>
                <h3 class="text-xl font-semibold">Generate & Send Invoices</h3>
                <p class="text-indigo-300 max-w-sm mx-auto">Create professional invoices in seconds and send them to clients directly from the platform.</p>
            </div>
            <div class="fade-in space-y-4">
                <div class="mx-auto w-20 h-20 rounded-full bg-indigo-700 flex items-center justify-center text-indigo-300 font-bold text-2xl select-none">3</div>
                <h3 class="text-xl font-semibold">Get Paid Faster</h3>
                <p class="text-indigo-300 max-w-sm mx-auto">Automate reminders and track payments to get your cash flow moving smoothly.</p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="max-w-7xl mx-auto px-6 md:px-12 py-20 text-center space-y-12">
        <h2 class="text-4xl font-extrabold fade-in">Simple, Transparent Pricing</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="fade-in rounded-xl border border-indigo-700 p-8 bg-indigo-800 shadow-lg space-y-6 hover:scale-105 transition-transform cursor-default">
                <h3 class="text-xl font-semibold">Basic</h3>
                <p class="text-indigo-300 text-4xl font-extrabold">$9<span class="text-lg font-normal">/month</span></p>
                <ul class="text-indigo-400 space-y-2 text-left">
                    <li>Up to 10 invoices</li>
                    <li>Automated reminders</li>
                    <li>Email support</li>
                </ul>
                <button class="btn-primary bg-indigo-600 px-6 py-3 rounded-md font-semibold w-full">Choose Plan</button>
            </div>
            <div class="fade-in rounded-xl border border-indigo-500 p-8 bg-indigo-700 shadow-lg space-y-6 hover:scale-105 transition-transform cursor-default">
                <h3 class="text-xl font-semibold">Pro</h3>
                <p class="text-indigo-300 text-4xl font-extrabold">$29<span class="text-lg font-normal">/month</span></p>
                <ul class="text-indigo-400 space-y-2 text-left">
                    <li>Unlimited invoices</li>
                    <li>Automated reminders & subscriptions</li>
                    <li>Priority support</li>
                </ul>
                <button class="btn-primary bg-indigo-600 px-6 py-3 rounded-md font-semibold w-full">Choose Plan</button>
            </div>
            <div class="fade-in rounded-xl border border-indigo-700 p-8 bg-indigo-800 shadow-lg space-y-6 hover:scale-105 transition-transform cursor-default">
                <h3 class="text-xl font-semibold">Enterprise</h3>
                <p class="text-indigo-300 text-4xl font-extrabold">Custom</p>
                <ul class="text-indigo-400 space-y-2 text-left">
                    <li>Personalized setup</li>
                    <li>Dedicated account manager</li>
                    <li>24/7 support</li>
                </ul>
                <button class="btn-primary bg-indigo-600 px-6 py-3 rounded-md font-semibold w-full">Contact Us</button>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bg-indigo-900 py-16 px-6 md:px-12 max-w-7xl mx-auto text-center fade-in">
        <h2 class="text-3xl font-extrabold mb-6">Get In Touch</h2>
        <p class="text-indigo-300 mb-8 max-w-xl mx-auto">Questions? Feedback? Just want to say hi? We'd love to hear from you.</p>
        <form action="#" method="POST" class="max-w-xl mx-auto space-y-6 text-left">
            <label class="block">
                <span class="text-indigo-200 font-semibold mb-1 block">Your Email</span>
                <input type="email" name="email" required class="w-full px-4 py-3 rounded-md bg-indigo-800 border border-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="you@example.com" />
            </label>
            <label class="block">
                <span class="text-indigo-200 font-semibold mb-1 block">Message</span>
                <textarea name="message" required rows="4" class="w-full px-4 py-3 rounded-md bg-indigo-800 border border-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Write your message here"></textarea>
            </label>
            <button type="submit" class="btn-primary bg-indigo-600 px-6 py-3 rounded-md font-semibold w-full">Send Message</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="bg-indigo-900 py-8 px-6 md:px-12 text-indigo-400 text-sm text-center">
        &copy; 2025 FlowQuest. All rights reserved.
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Intersection Observer for fade-in animations
        const fadeEls = document.querySelectorAll('.fade-in');

        const observer = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            }
        );

        fadeEls.forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>
