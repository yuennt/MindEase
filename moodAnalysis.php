<?php

session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mood Analysis</title>
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="mood.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>


<body>
    <div class="mood-container">
        <form class="mood-form" action="analyzeMood.php" method="POST">
            <!-- Back Button -->
            <button type="button" class="goBackbtn" onclick="window.location.href='homepage.php'">
                <i class="bi bi-arrow-left"></i>
            </button>

            <!-- Emoji Decoration -->
            <i class="bi bi-emoji-smile emotion happy"></i>
            <i class="bi bi-emoji-frown emotion sad"></i>

            <h2> Mood Analysis </h2>
            <p>Welcome back, <?= htmlspecialchars($username); ?></p>

            <div class="input-group">
                <label>How are you feeling today?</label>

                <select name="mood" required>
                    <option value="Happy">Happy</option>
                    <option value="Calm">Calm</option>
                    <option value="Neutral">Neutral</option>
                    <option value="Sad">Sad</option>
                    <option value="Stressed">Stressed</option>
                    <option value="Anxious">Anxious</option>
                </select>
            </div>

            <div class="input-group">
                <label>Mood Intensity (1-10)</label>
                <input type="number" name="intensity" min="1" max="10" placeholder="Enter intensity level" required>
            </div>

            <div class="input-group">
                <label>Describe your feelings</label>
                <textarea name="journal" rows="5" placeholder="Write about your day..." required></textarea>
            </div>


            <button type="submit" class="moodBtn">
                Analyze Mood
            </button>
        </form>
    </div>
</body>

</html>