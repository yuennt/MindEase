<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: signIn.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "mindease");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$email = $_SESSION['user_email'];

if (isset($_POST['change'])) {
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    // Get current password
    $stmt = $conn->prepare("SELECT password FROM user WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>
                alert('User not found.');
                window.location='changePassword.php';
              </script>";
        exit();
    }

    $user = $result->fetch_assoc();

    // Check current password
    if ($current != $user['password']) {
        echo "<script>
                alert('Current password is incorrect!');
                window.location='changePassword.php';
              </script>";
        exit();
    }

    // Password length
    if (strlen($new) < 6) {
        echo "<script>
                alert('New password must be at least 6 characters.');
                window.location='changePassword.php';
              </script>";
        exit();
    }

    // Confirm password
    if ($new != $confirm) {
        echo "<script>
                alert('New passwords do not match.');
                window.location='changePassword.php';
              </script>";
        exit();
    }

    // Same password
    if ($current == $new) {
        echo "<script>
                alert('New password must be different from current password.');
                window.location='changePassword.php';
              </script>";
        exit();
    }

    // Update password
    $update = $conn->prepare("UPDATE user SET password=?, confirmPassword=? WHERE email=?");
    $update->bind_param("sss", $new, $confirm, $email);

    if ($update->execute()) {

        echo "<script>
                alert('Password changed successfully!');
                window.location='profile.php';
              </script>";
    } else {

        echo "<script>
                alert('Failed to change password!');
              </script>";

        echo mysqli_error($conn);
    }

    $update->close();
    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password</title>
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
            height: 100vh;
            background: linear-gradient(rgba(187, 180, 180, .5), rgba(172, 161, 161, .5)),
                url('images/smile 2.jpg');
            background-size: cover;
            background-position: center;
        }

        .card {
            width: 420px;
            padding: 40px;
            background: rgba(255, 255, 255, .2);
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
            margin-bottom: 25px;
        }

        .input-group {
            margin-bottom: 18px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 12px 45px 12px 12px;
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
            top: 50%;
            right: 15px;
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
        <button class="back" onclick="window.location='profile.php'">
            <i class="bi bi-arrow-left"></i>
        </button>

        <h2>Change Password</h2>

        <form method="POST">
            <div class="input-group">
                <input type="password" name="current_password" id="current" placeholder="Current Password" required>
                <i class="bi bi-eye-slash toggle" onclick="togglePassword('current',this)"></i>
            </div>

            <div class="input-group">
                <input type="password" name="new_password" id="new" placeholder="New Password" required>
                <i class="bi bi-eye-slash toggle" onclick="togglePassword('new',this)"></i>
            </div>

            <div class="input-group">
                <input type="password" name="confirm_password" id="confirm" placeholder="Confirm New Password" required>
                <i class="bi bi-eye-slash toggle" onclick="togglePassword('confirm',this)"></i>
            </div>

            <button type="submit" name="change" class="btn">
                Change Password
            </button>
        </form>

    </div>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            }

        }
    </script>

</body>

</html>