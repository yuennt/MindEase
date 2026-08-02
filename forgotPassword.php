<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "mindease");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['reset'])) {

    $email = trim($_POST['email']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Empty validation
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {

        echo "<script>
        alert('Please fill in all fields.');
        window.location='forgotPassword.php';
        </script>";
        exit();
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
        alert('Invalid email address.');
        window.location='forgotPassword.php';
        </script>";
        exit();
    }

    // Password length
    if (strlen($newPassword) < 6) {
        echo "<script>
        alert('Password must be at least 6 characters.');
        window.location='forgotPassword.php';
        </script>";
        exit();
    }

    // Password match
    if ($newPassword != $confirmPassword) {
        echo "<script>
        alert('Passwords do not match.');
        window.location='forgotPassword.php';
        </script>";
        exit();
    }

    // Check email
    $check = $conn->prepare("SELECT * FROM user WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows == 0) {
        echo "<script>
        alert('Email not found.');
        window.location='forgotPassword.php';
        </script>";
        exit();
    }

    // Update password
    $update = $conn->prepare("UPDATE user SET password=?, confirmPassword=? WHERE email=?");
    $update->bind_param("sss", $newPassword, $confirmPassword, $email);

    if ($update->execute()) {
        echo "<script>
        alert('Password reset successfully!');
        window.location='signIn.php';
        </script>";
    } else {

        echo "<script>
        alert('Failed to reset password.');
        </script>";
    }

    $check->close();
    $update->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password</title>
    <link rel="icon" href="images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(rgba(187, 180, 180, .5), rgba(172, 161, 161, .5)),
                url('images/smile 2.jpg');
            background-size: cover;
            background-position: center;
        }

        .card {
            width: 420px;
            padding: 40px;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
            position: relative;
        }

        .back {
            position: absolute;
            top: 20px;
            left: 20px;
            border: none;
            background: none;
            font-size: 28px;
            cursor: pointer;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            background: rgba(255, 255, 255, 0.25);
            border: 3px solid #bbb;
            border-radius: 15px;
            outline: none;
            font-size: 13px;
        }

        .input-group input:focus {
            border-color: #666;
        }

        .toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
        }

        .btn {
            display: block;
            margin: 0 auto;
            width: 50%;
            padding: 14px;
            background: #b58422;
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        .btn:hover {
            background: #a97d2e;
            opacity: 0.9;
            transform: scale(1.02);
        }
    </style>

</head>

<body>

    <div class="card">

        <button class="back" onclick="window.location='signIn.php'">
            <i class="bi bi-arrow-left"></i>
        </button>

        <h2>Forgot Password</h2>

        <form method="POST">

            <div class="input-group">

                <input
                    type="email"
                    name="email"
                    placeholder="Registered Email"
                    required>

            </div>

            <div class="input-group">

                <input
                    type="password"
                    id="new"
                    name="new_password"
                    placeholder="New Password"
                    required>

                <i class="bi bi-eye-slash toggle"
                    onclick="togglePassword('new',this)"></i>

            </div>

            <div class="input-group">

                <input
                    type="password"
                    id="confirm"
                    name="confirm_password"
                    placeholder="Confirm Password"
                    required>

                <i class="bi bi-eye-slash toggle"
                    onclick="togglePassword('confirm',this)"></i>

            </div>

            <button
                type="submit"
                name="reset"
                class="btn">

                Reset Password

            </button>

        </form>

    </div>

    <script>
        function togglePassword(id, icon) {

            const input = document.getElementById(id);

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
