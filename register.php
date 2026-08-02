<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="registerStyle.css">

    <script type="module" src="register.js" defer></script>

</head>

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
        /*background:linear-gradient(200deg, #b3f8e385, #6de3f3);*/
        background: linear-gradient(rgba(187, 180, 180, 0.5), rgba(172, 161, 161, 0.5)), url('images/smile 2.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>

<body>
    <div class="form-container">
        <form id="" registerForm" action="registerValidate.php" method="POST">
            <button type="button" class="goBackbtn" onclick="window.location.href= 'login.php'">
                <i class="bi bi-arrow-left"></i>
            </button>

            <!-- Emotion Icons -->
            <i class="bi bi-emoji-smile emotion happy"></i>
            <i class="bi bi-emoji-frown emotion sad"></i>

            <h2>Create Account</h2>
            <p>Please enter your credentials to create new account</p>

            <div class="input-group">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>

            <div class="input-group password-group">
                <input type="password" name="password" placeholder="Password" id="password" required>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
            </div>

            <div class="input-group password-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('confirm_password', this)"></i>

            </div>

            <button type="submit" name="register" class="signupBtn" id="submit">Register</button>
            <button type="button" class="signinBtn" onclick="window.location.href='login.php'">Sign In</button>

        </form>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }
    </script>

</body>

</html>
