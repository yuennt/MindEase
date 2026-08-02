<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "mindease";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: moodAnalysis.php");
    exit();
}

$id = $_SESSION['user_id'];

$mood = trim($_POST['mood']);
$intensity = (int)$_POST['intensity'];
$journal = strtolower(trim($_POST['journal']));

// Default score according to selected mood
switch ($mood) {
    case "Happy":
        $score = 90;
        break;

    case "Calm":
        $score = 80;
        break;

    case "Neutral":
        $score = 60;
        break;

    case "Stressed":
        $score = 40;
        break;

    case "Sad":
        $score = 30;
        break;

    case "Anxious":
        $score = 20;
        break;

    default:
        $score = 50;
}

// Positive words
$positive = ["happy", "good", "great", "love", "relaxed", "excited", "peaceful", "thankful", "joyful", "content", "optimistic", "hopeful", "energetic", "confident", "proud", "satisfied", "cheerful", "calm", "relieved", "motivated"];

// Negative words
$negative = ["sad", "stress", "stressed", "anxious", "anxiety", "angry", "depressed", "lonely", "cry", "tired", "panic", "hopeless", "frustrated", "overwhelmed", "guilty", "ashamed", "fearful", "nervous", "worried", "disappointed"];

foreach ($positive as $word) {
    if (strpos($journal, $word) !== false) {
        $score += 5;
    }
}

foreach ($negative as $word) {
    if (strpos($journal, $word) !== false) {
        $score -= 5;
    }
}

// Keep score between 0 and 100
if ($score > 100) $score = 100;
if ($score < 0) $score = 0;

// Recommendation
if ($score >= 80) {
    $result = "Excellent";
    $recommendation = "You seem to be feeling great today. Keep maintaining healthy habits.";
} elseif ($score >= 60) {
    $result = "Good";
    $recommendation = "Your emotional wellbeing is stable. Continue your positive routine.";
} elseif ($score >= 40) {
    $result = "Moderate";
    $recommendation = "You may be experiencing some stress. Try meditation or deep breathing.";
} else {
    $result = "Low";
    $recommendation = "You seem emotionally distressed. Consider talking to someone you trust or a mental health professional.";
}

// Save mood analysis
$sql = "INSERT INTO mood_logs
(user_id, mood, intensity, journal, mood_score, recommendation)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssisis", //i → user_id, s → mood, i → intensity, s → journal, i → mood_score, s → recommendation
    $id,
    $mood,
    $intensity,
    $journal,
    $score,
    $recommendation
);

if (mysqli_stmt_execute($stmt)) {
    // Saved successfully
} else {
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Mood Analysis Result</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(187, 180, 180, .5), rgba(172, 161, 161, .5)),
                url("images/smile 2.jpg");
            background-size: cover;
            background-position: center;
        }

        /* Result Card */
        .result-container {
            width: 500px;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .result-card {
            width: 500px;
            padding: 40px;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 25px;
            box-shadow: 0 10px 32px rgba(0, 0, 0, .4);
        }

        .goBackbtn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: transparent;
            border: none;
            font-size: 28px;
            color: black;
            cursor: pointer;
        }

        .goBackbtn:hover {
            transform: scale(1.2);
        }

        /*Heading */
        .result-card h2 {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: black;
            margin-bottom: 30px;
        }

        /* Information */
        .info-row {
            display: flex;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .info-row strong {
            width: 120px;
            color: black;
        }

        .info-row span {
            color: #444;
        }

        /*Label*/
        .result-card label {
            display: block;
            margin-top: 20px;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /*Journal*/
        .journal-box {
            min-height: 80px;
            padding: 15px;
            background: rgba(255, 255, 255, .35);
            border: 2px solid rgba(255, 255, 255, .45);
            border-radius: 15px;
            color: #444;
            font-size: 12px;
            line-height: 1.5;
        }

        /*Progress */
        .progress {
            width: 100%;
            height: 25px;
            margin-top: 5px;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: white;
        }

        .good-score {
            background: #28a745;
        }

        .medium-score {
            background: #f0ad4e;
            color: black;
        }

        .low-score {
            background: #dc3545;
        }

        /*Recommendation*/
        .result-box {
            margin-top: 25px;
            padding: 20px;
            border-radius: 20px;
            border: 2px solid rgba(255, 255, 255, .45);
            background: rgba(255, 255, 255, .35);
        }

        .result-box h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
        }

        .result-box p {
            color: #555;
            font-size: 12px;
            line-height: 1.7;
        }

        /*Buttons*/
        .button-group {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 35px;
        }

        .button-group a {
            text-decoration: none;
            width: 180px;
            padding: 13px;
            border-radius: 15px;
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            transition: .2s;
        }

        .button-group a:hover {
            transform: scale(1.05);
            opacity: .9;
        }

        .again-btn {
            background: #a9825f;
        }

        .weekly-btn {
            background: #a9825f;
        }


        /* Responsive */
        @media(max-width:768px) {
            .result-card {
                width: 92%;
                padding: 30px;
            }

            .info-row {
                flex-direction: column;
            }

            .info-row strong {
                width: 100%;
                margin-bottom: 5px;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group a {
                width: 100%;
            }

        }
    </style>
</head>

<body>

    <div class="result-container">
        <div class="result-card">
            <button type="button" class="goBackbtn" onclick="window.location.href='homepage.php'">
                <i class="bi bi-arrow-left"></i>
            </button>

            <h2>Mood Analysis Result</h2>

            <div class="info-row">
                <strong>Selected Mood :</strong>
                <span><?= htmlspecialchars($mood); ?></span>
            </div>

            <div class="info-row">
                <strong>Intensity :</strong>
                <span><?= $intensity; ?>/10</span>
            </div>

            <label>Journal</label>

            <div class="journal-box">
                <?= nl2br(htmlspecialchars($journal)); ?>
            </div>

            <label>Wellbeing Score</label>

            <div class="progress">
                <div
                    class="progress-bar
                <?= ($score >= 80) ? 'good-score' : (($score >= 40) ? 'medium-score' : 'low-score'); ?>"
                    style="width:<?= $score ?>%;">
                    <?= $score ?>/100
                </div>
            </div>

            <div class="result-box">
                <h3><?= $result ?></h3>
                <p><?= $recommendation ?></p>
            </div>

            <div class="button-group">
                <a href="moodAnalysis.php" class="again-btn">
                    <i class="bi bi-arrow-repeat"></i>
                    Analyze Again
                </a>

                <a href="weeklyMood.php" class="weekly-btn">
                    <i class="bi bi-bar-chart-line"></i>
                    Weekly Analysis
                </a>
            </div>
        </div>
    </div>

</body>

</html>