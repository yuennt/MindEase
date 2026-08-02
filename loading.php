<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Loading...</title>
    <link rel="icon" href="images/favicon.ico">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(187, 180, 180, .5), rgba(172, 161, 161, .5)),
                url("images/smile 2.jpg");
            background-size: cover;
            background-position: center;
        }

        .loader {
            width: 500px;
            padding: 40px;
            text-align: center;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
        }

        .main i {
            font-size: 80px;
            color: #333;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .loader h2 {
            margin-top: 20px;
            font-size: 20px;
            color: #333;
        }

        /* Progress */
        .progress-container {
            width: 100%;
            height: 28px;
            background: white;
            border-radius: 20px;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
        }

        .progress-bar {
            width: 0%;
            height: 100%;
            background: #7bb7d5;
            border-radius: 20px;
            transition: .15s linear;
        }

        /* Moving emoji */
        .progress-emoji {
            position: absolute;
            top: 50%;
            left: 0;
            right: 3;
            font-size: 28px;
            color: #333;
            transition: 0.15s linear;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .percent {
            margin-top: 20px;
            font-size: 32px;
            font-weight: bold;
        }

        .status {
            margin-top: 10px;
            font-size: 18px;
            color: #555;
            font-weight: 600;
        }
    </style>

</head>

<body>
    <div class="loader">
        <div class="main">
            <i id="mainEmoji" class="bi bi-emoji-frown"></i>
        </div>

        <h2>Preparing Mental Wellbeing Assistant</h2>

        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
            <i id="progressEmoji" class="bi bi-emoji-frown progress-emoji"></i>
        </div>

        <div class="percent" id="percent">0%</div>
        <div class="status" id="status">Starting...</div>
    </div>


    <script>
        let progress = 0;

        let loading = setInterval(function() {
            progress++;
            document.getElementById("progressBar").style.width = progress + "%";
            document.getElementById("percent").innerHTML = progress + "%";

            let emoji = "bi bi-emoji-frown";
            let message = "Loading mental health resources...";

            if (progress >= 25) {
                emoji = "bi bi-emoji-expressionless";
                message = "Initializing wellbeing features...";
            }

            if (progress >= 50) {
                emoji = "bi bi-emoji-neutral";
                message = "Connecting AI Assistant...";
            }

            if (progress >= 75) {
                emoji = "bi bi-emoji-smile";
                message = "Almost ready...";
            }

            if (progress >= 100) {
                emoji = "bi bi-emoji-smile";
                message = "Welcome to MindEase!";
            }


            // Change big emoji
            document.getElementById("mainEmoji").className = emoji;

            // Change moving emoji
            let moving = document.getElementById("progressEmoji");
            moving.className = emoji + " progress-emoji";

            // Move emoji exactly with progress
            moving.style.left = `calc(${progress}% - 15px)`;
            document.getElementById("status").innerHTML = message;

            if (progress >= 100) {
                clearInterval(loading);

                setTimeout(function() {
                    window.location.href = "homepage.php";
                }, 1000);
            }
        }, 50);
    </script>

</body>

</html>