<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindEase</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Social Media Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">



    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(rgba(187, 180, 180, 0.5), rgba(172, 161, 161, 0.5)),
                url('images/smile 2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: black;
        }

        #loginPage {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 380px;
            /* background: url('images/smile 2.jpg') no-repeat center center; */
            /*background: rgb(233, 220, 220);*/
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            padding: 35px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.4);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /*Emotion Icons */
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

        .login-card img {
            width: 100px;
            height: 100px;
        }

        .login-card p {
            color: white !important;
            margin-top: 3px;
            font-size: 30px;
            font-family: 'Impact', sans-serif;
            letter-spacing: 4px;
        }

        .login-card span {
            color: #6b9af0;
            font-size: 30px;
            font-family: 'Impact', sans-serif;
            letter-spacing: 4px;
        }

        .loginBtn {
            width: 50%;
            padding: 10px;
            background: #b58422;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            transition: 0.2s;
        }

        .loginBtn:hover {
            background: #a97d2e;
            opacity: 1;
            transform: scale(1.05);
        }

        .registerBtn {
            width: 50%;
            padding: 10px;
            background: #b58422;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .registerBtn:hover {
            background: #a97d2e;
            opacity: 1;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <!-- Login Page -->
    <div id="loginPage">
        <div class="login-card">

            <!-- Emotion Icons -->
            <i class="bi bi-emoji-smile emotion happy"></i>
            <i class="bi bi-emoji-frown emotion sad"></i>

            <img src="images/mindEase.png" alt="MindEase" width="80" height="80">
            <p>Mind<span>Ease</span></p>

            <form id="loginForm" method="POST">
                <button type="button" class="loginBtn" id="submit" onclick="login()">Login</button>
                <button type="button" class="registerBtn" onclick="register()">Register</button>
            </form>
        </div>
    </div>

    <script>
        function login() {
            window.location.href = "signIn.php";
        };

        function register() {
            window.location.href = "register.php";
        };
    </script>
</body>
A

</html>
