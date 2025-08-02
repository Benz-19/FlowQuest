<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowQuest - Freelancer Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            background-color: #F9FAFB;
            color: #1F2937;
        }

        .card {
            background-color: #FFFFFF;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .sidebar-nav-link {
            color: #6B7280;
            transition: color 0.2s, background-color 0.2s;
        }

        .sidebar-nav-link:hover {
            color: #1F2937;
            background-color: #F3F4F6;
        }

        #sidebar {
            background-color: #FFFFFF;
            border-right: 1px solid #E5E7EB;
        }

        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 p-6 z-50 transform md:translate-x-0 -translate-x-full md:relative md:w-64 md:flex-shrink-0">
            <div class="flex items-center justify-between mb-10">
                <div class="text-2xl font-bold">FlowQuest</div>
                <button id="close-sidebar-btn" class="md:hidden text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="space-y-2">
                <a href="#" class="flex items-center space-x-4 p-3 rounded-lg sidebar-nav-link hover:text-gray-900">
                    <i class="fas fa-chart-line fa-lg"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-4 p-3 rounded-lg sidebar-nav-link hover:text-gray-900">
                    <i class="fas fa-file-invoice-dollar fa-lg"></i>
                    <span>Invoices</span>
                </a>
                <a href="#" class="flex items-center space-x-4 p-3 rounded-lg sidebar-nav-link hover:text-gray-900">
                    <i class="fas fa-users fa-lg"></i>
                    <span>Clients</span>
                </a>
                <a href="#" class="flex items-center space-x-4 p-3 rounded-lg sidebar-nav-link hover:text-gray-900">
                    <i class="fas fa-cog fa-lg"></i>
                    <span>Settings</span>
                </a>
            </nav>
            <div class="mt-auto absolute bottom-6 left-6 right-6">
                <a href="#" class="flex items-center space-x-4 p-3 rounded-lg sidebar-nav-link hover:text-gray-900">
                    <i class="fas fa-sign-out-alt fa-lg"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-6 lg:p-12">
            <header class="flex items-center justify-between pb-6 mb-6">
                <div class="flex items-center space-x-4">
                    <button id="open-sidebar-btn" class="md:hidden text-gray-500 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <h1 class="text-3xl font-bold">Welcome, <span id="username">Kingsley</span>!</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-gray-400"></div>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div id="metrics" class="p-6 rounded-xl card lg:col-span-1">
                    <h2 class="text-xl font-semibold mb-4">Metrics</h2>
                    <div class="space-y-4 text-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Total Projects:</span>
                            <span id="total-projects" class="font-bold">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Completed Projects:</span>
                            <span id="completed-projects" class="font-bold text-green-500">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Active Projects:</span>
                            <span id="active-projects" class="font-bold text-blue-500">0</span>
                        </div>
                    </div>
                </div>

                <div id="recent-activity" class="p-6 rounded-xl card lg:col-span-2">
                    <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                    <ul id="activity-list" class="space-y-4">
                    </ul>
                </div>
            </div>

            <div id="income-analytics" class="p-6 rounded-xl card">
                <h2 class="text-xl font-semibold mb-4">Income Analytics</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4 text-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Total Income:</span>
                            <span id="total-income" class="font-bold text-green-500">$0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Last Month:</span>
                            <span id="last-month" class="font-semibold">$0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">This Month:</span>
                            <span id="this-month" class="font-semibold">$0</span>
                        </div>
                    </div>
                    <div class="h-64 chart-container">
                        <canvas id="income-chart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/freelancer_dashboard.js"></script>
</body>

</html>
