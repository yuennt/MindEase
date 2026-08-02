<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "mindease";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$id = $_SESSION['user_id'];

$sql = "SELECT mood, mood_score, created_at
        FROM mood_logs
        WHERE user_id = ?
        AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ORDER BY created_at ASC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total = 0;
$count = 0;
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    $total += $row['mood_score'];
    $count++;
}

$average = ($count > 0) ? round($total / $count) : 0;

// Chart data
$dates = [];
$scores = [];

foreach ($data as $row) {
    $dates[] = date(
        "d M",
        strtotime($row['created_at'])
    );

    $scores[] = $row['mood_score'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Weekly Mood Analysis</title>
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="mood.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(rgba(187, 180, 180, 0.5), rgba(172, 161, 161, 0.5)), url('images/smile 2.jpg');
        background-size: cover;
        background-position: center;
    }
</style>

<body>
    <div class="weekly-container">
        <div class="weekly-card">
            <button type="button" class="goBackbtn" onclick="window.location.href='homepage.php'">
                <i class="bi bi-arrow-left"></i>
            </button>

            <h2>Weekly Mood Analysis</h2>

            <h3>Average Wellbeing Score</h3>

            <div class="progress">
                <div class="progress-bar" style="width:<?= $average ?>%"><?= $average ?>/100</div>
            </div>

            <!-- Chart -->
            <div class="chart-box">
                <h3>Weekly Mood Trend </h3>
                <canvas id="moodChart"></canvas>
            </div>

            <h3>Last 7 Days Record</h3>


            <?php if ($count > 0) { ?>
                <table class="mood-table">
                    <tr>
                        <th> Date</th>
                        <th>Mood</th>
                        <th>Score</th>
                    </tr>

                    <?php foreach ($data as $row) { ?>
                        <tr>
                            <td><?= date("d M Y", strtotime($row['created_at'])); ?></td>
                            <td><?= htmlspecialchars($row['mood']); ?> </td>
                            <td><?= $row['mood_score']; ?>/100</td>
                        </tr>
                    <?php } ?>
                </table>

            <?php } else { ?>
                <div class="no-record">
                    No mood records found for the last 7 days.
                </div>
            <?php } ?>

            <div class="weekly-buttons">
                <a href="moodAnalysis.php">
                    <button class="again-btn">
                        <i class="bi bi-arrow-repeat"></i>
                        Analyze Again
                    </button>
                </a>
            </div>
        </div>
    </div>

    <script>
        const moodDates = <?= json_encode($dates); ?>;
        const moodScores = <?= json_encode($scores); ?>;

        const ctx = document
            .getElementById('moodChart')
            .getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: moodDates,
                datasets: [{
                    label: 'Mood Score',
                    data: moodScores,
                    borderColor: '#a9825f',
                    backgroundColor: 'rgba(169,130,95,0.3)',
                    borderWidth: 3,
                    pointBackgroundColor: '#0066cc',
                    pointRadius: 6,
                    tension: 0.4,
                    fill: true
                }]
            },

            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>