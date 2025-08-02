// Sidebar functionality
const sidebar = document.getElementById('sidebar');
const openSidebarBtn = document.getElementById('open-sidebar-btn');
const closeSidebarBtn = document.getElementById('close-sidebar-btn');

openSidebarBtn.addEventListener('click', () => {
    sidebar.classList.add('open');
});

closeSidebarBtn.addEventListener('click', () => {
    sidebar.classList.remove('open');
});

// Chart.js configuration
let incomeChart;

function createIncomeChart(monthlyLabels, monthlyIncomeData) {
    const ctx = document.getElementById('income-chart').getContext('2d');

    if (incomeChart) {
        incomeChart.destroy();
    }

    incomeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Income',
                data: monthlyIncomeData,
                borderColor: '#60A5FA', // Tailwind blue-400
                backgroundColor: 'rgba(96, 165, 250, 0.2)',
                tension: 0.4,
                pointBackgroundColor: '#2563EB', // Tailwind blue-600
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#2563EB',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.2)',
                    },
                    ticks: {
                        callback: function (value) {
                            return '$' + value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `Income: $${context.parsed.y}`;
                        }
                    }
                }
            }
        }
    });
}

async function loadDashboard() {
    try {
        const response = await fetch('/api/dashboard');
        if (!response.ok) throw new Error('Failed to fetch dashboard data');

        const data = await response.json();

        // Update username
        document.getElementById('username').textContent = data.user_data.user_data.username || 'User';

        // Update metrics
        document.getElementById('total-projects').textContent = data.metrics.total_projects;
        document.getElementById('completed-projects').textContent = data.metrics.completed_projects;
        document.getElementById('active-projects').textContent = data.metrics.active_projects;

        // Update recent activity
        const activityList = document.getElementById('activity-list');
        activityList.innerHTML = '';
        data.recent_activity.forEach(activity => {
            const li = document.createElement('li');
            li.className = 'flex items-center space-x-3 p-3 bg-gray-50 rounded-lg shadow-sm transition-transform duration-200 transform hover:scale-[1.01]';
            const icon = document.createElement('i');
            icon.className = activity.status === 'completed' ? 'fas fa-check-circle text-green-500' : 'fas fa-spinner fa-spin text-blue-500';
            const text = document.createElement('span');
            text.textContent = `${activity.project} - ${activity.status}`;
            li.appendChild(icon);
            li.appendChild(text);
            activityList.appendChild(li);
        });

        // Update income analytics
        document.getElementById('total-income').textContent = `$${data.income_analytics.total_income}`;
        document.getElementById('last-month').textContent = `$${data.income_analytics.last_month}`;
        document.getElementById('this-month').textContent = `$${data.income_analytics.this_month}`;

        // Get monthly data for the chart, checking if it's available
        let monthlyData = data.income_analytics.total_income || [];
        console.log(data.income_analytics)

        // Use fallback data if the fetched data is empty or invalid
        if (monthlyData.length !== 0) {
            monthlyData = [
                { month: "Jan", income: 250 },
                { month: "Feb", income: 400 },
                { month: "Mar", income: 600 },
                { month: "Apr", income: 800 },
                { month: "May", income: 750 },
                { month: "Jun", income: 900 },
                { month: "Jul", income: 1100 },
                { month: "Aug", income: 1300 },
                { month: "Sep", income: 1500 },
                { month: "Oct", income: 1200 },
                { month: "Nov", income: 1800 },
                { month: "Dec", income: 2000 }
            ];
        }

        const monthlyLabels = monthlyData.map(item => item.month);
        const monthlyIncomes = monthlyData.map(item => item.income);

        createIncomeChart(monthlyLabels, monthlyIncomes);

    } catch (error) {
        console.error(error);
        alert('Unable to load dashboard data. Using fallback data.');

        // // Always create a chart with fallback data on error
        // const fallbackData = [
        //     { month: "Jan", income: 250 },
        //     { month: "Feb", income: 400 },
        //     { month: "Mar", income: 600 },
        //     { month: "Apr", income: 800 },
        //     { month: "May", income: 750 },
        //     { month: "Jun", income: 900 },
        //     { month: "Jul", income: 1100 },
        //     { month: "Aug", income: 1300 },
        //     { month: "Sep", income: 1500 },
        //     { month: "Oct", income: 1200 },
        //     { month: "Nov", income: 1800 },
        //     { month: "Dec", income: 2000 }
        // ];
        const monthlyLabels = fallbackData.map(item => item.month);
        const monthlyIncomes = fallbackData.map(item => item.income);
        createIncomeChart(monthlyLabels, monthlyIncomes);
    }
}

document.addEventListener('DOMContentLoaded', loadDashboard);
