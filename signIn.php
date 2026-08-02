<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "mindease";
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

if (!$conn) {
    die("Database Connection Failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare(
        "SELECT * FROM user WHERE email=? AND password=?"
    );


    $stmt->bind_param(
        "ss",
        $email,
        $password
    );

    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: loading.php");
        exit();
    } else {
        echo "
        <script>
        alert('Invalid Email or Password');
        window.location.href='signIn.php';
        </script>
        ";
        exit();
    }
    $stmt->close();
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            background: linear-gradient(rgba(187, 180, 180, 0.5), rgba(172, 161, 161, 0.5)),
                url('images/smile 2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .form-container {
            width: 450px;
            height: auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.4);
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }

        .emotion {
            position: absolute;
            font-size: 80px;
            opacity: 0.3;
            color: rgb(3, 80, 94);
            pointer-events: none;
        }


        .happy {
            top: -15px;
            right: -10px;
            transform: rotate(-15deg);
        }


        .sad {
            bottom: -20px;
            left: -10px;
            transform: rotate(-15deg);
        }

        .goBackbtn {
            position: absolute;
            top: 20px;
            left: 20px;
            color: black;
            background: none;
            border: none;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        h2 {
            font-size: 26px;
            color: black;
            margin-top: 15px;
            margin-bottom: 8px;
            text-align: center;
        }

        p {
            color: #666;
            margin-bottom: 20px;
            font-size: 12px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.25);
            color: black;
            border: 3px solid rgb(171, 164, 164);
            border-radius: 15px;
            font-size: 12px;
            outline: none;
        }

        .input-group input:focus {
            border-color: #666;
        }

        .password-group {
            position: relative;
        }

        .password-group input {
            padding-right: 50px;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: black;
            font-size: 20px;
            cursor: pointer;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 12px;
        }

        .options a {
            color: #0066cc;
            text-decoration: none;
        }

        .btn {
            width: 100%;
            height: 55px;
            border: none;
            border-radius: 15px;
            background: #a9825f;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        .signup-text {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }

        .signup-text a {
            color: #0066cc;
            text-decoration: none;
        }
    </style>

</head>

<body>


    <div class="form-container">
        <form method="POST" action="signIn.php">
            <button type="button" class="goBackbtn" onclick="window.location.href='login.php'">
                <i class="bi bi-arrow-left"></i>
            </button>

            <i class="bi bi-emoji-smile emotion happy"></i>
            <i class="bi bi-emoji-frown emotion sad"></i>

            <h2>Sign In</h2>
            <p> Please enter your credentials to login your account</p>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" id="email" required>
            </div>

            <div class="input-group password-group">
                <input type="password" name="password" placeholder="Password" id="password" required>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
            </div>

            <div class="options">
                <label><input type="checkbox"> Remember Me</label>
                <a href="forgotPassword.php">Forgot Password?</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="signup-text">
                Don't have an account?
                <a href="register.php">Register</a>
            </div>
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
