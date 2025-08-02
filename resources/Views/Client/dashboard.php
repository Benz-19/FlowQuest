<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user_details']['username']) ?>!</h1>

    <div id="dashboard">
        <section id="metrics">
            <h2>Metrics</h2>
            <p>Total Projects: <span id="total-projects">0</span></p>
            <p>Completed Projects: <span id="completed-projects">0</span></p>
            <p>Active Projects: <span id="active-projects">0</span></p>
        </section>

        <section id="recent-activity">
            <h2>Recent Activity</h2>
            <ul id="activity-list"></ul>
        </section>

        <section id="income-analytics">
            <h2>Income Analytics</h2>
            <p>Total Income: $<span id="total-income">0</span></p>
            <p>Last Month: $<span id="last-month">0</span></p>
            <p>This Month: $<span id="this-month">0</span></p>
        </section>
    </div>

    <script>
        async function loadDashboard() {
            try {
                const response = await fetch('/api/dashboard');
                if (!response.ok) throw new Error('Failed to fetch dashboard data');

                const data = await response.json();

                // Update metrics
                document.getElementById('total-projects').textContent = data.metrics.total_projects;
                document.getElementById('completed-projects').textContent = data.metrics.completed_projects;
                document.getElementById('active-projects').textContent = data.metrics.active_projects;

                // Update recent activity
                const activityList = document.getElementById('activity-list');
                activityList.innerHTML = '';
                data.recent_activity.forEach(activity => {
                    const li = document.createElement('li');
                    li.textContent = `${activity.project} - ${activity.status}`;
                    activityList.appendChild(li);
                });

                // Update income analytics
                document.getElementById('total-income').textContent = data.income_analytics.total_income;
                document.getElementById('last-month').textContent = data.income_analytics.last_month;
                document.getElementById('this-month').textContent = data.income_analytics.this_month;
            } catch (error) {
                console.error(error);
                alert('Unable to load dashboard data.');
            }
        }

        loadDashboard();
    </script>
</body>

</html>
