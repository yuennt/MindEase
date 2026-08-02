<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: signIn.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "mindease");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

$email = $_SESSION['user_email'];

$stmt = $conn->prepare(
    "SELECT * FROM user WHERE email=?"
);

$stmt->bind_param(
    "s",
    $email
);


$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found";
    exit();
}

$stmt->close();
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /*background: #eef1f7;*/
            background: linear-gradient(rgba(187, 180, 180, 0.5), rgba(172, 161, 161, 0.5)),
                url('images/smile 2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            width: 400px;
            height: 480px;
            background: rgb(233, 220, 220);
            ;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .goBackbtn {
            position: absolute;
            top: 170px;
            left: 680px;
            color: black;
            background: none;
            border: none;
            font-size: 30px;
            cursor: pointer;
            transition: 0.2s;
            z-index: 1000;
        }

        .goBackbtn:hover {
            transform: scale(1.2);
        }

        .passwordBtn {
            position: absolute;
            top: 170px;
            right: 680px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.5);
            /*background: none;*/
            border: none;
            border-radius: 50%;
            color: black;
            /*font-size: 22px;*/
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.1s;
            z-index: 500;
        }

        .passwordBtn:hover {
            background: #cbd8d5;
            transform: scale(1.09);
        }


        .passwordBtn i {
            font-size: 20px;
        }

        .cover {
            height: 150px;
            background: url('https://www.shutterstock.com/shutterstock/videos/1035356975/thumb/1.jpg?ip=x480') center/cover;
        }

        .avatar-container {
            text-align: center;
            margin-top: -60px;
        }

        .profile_image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid rgb(165, 162, 162);
            object-fit: cover;
        }

        .profile-body {
            padding: 20px;
            text-align: center;
        }

        .profile-body h2 {
            margin-top: 10px;
            color: #333;
            font-size: 25px;
            font-weight: bold;
        }

        .profile-body p {
            color: #777;
            margin-top: 5px;
            font-size: 14px;
        }

        .info {
            text-align: center;
            margin-top: 20px;
        }

        .info-item {
            margin-bottom: 40px;
        }

        .label {
            font-weight: bold;
            color: #333;
        }

        .button-group {
            display: flex;
            gap: 1px;
            margin-top: 10px;
        }

        .button-group i {
            font-size: 14px;
            margin-right: 5px;
        }

        .edit,
        .logout {
            display: block;
            margin: 0 auto;
            width: 40%;
            margin-top: 15px;
            padding: 14px;
            background: #b58422;
            color: white;
            text-decoration: none;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
        }

        .edit:hover,
        .logout:hover {
            background: #a97d2e;
            opacity: 1;
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <div class="profile-card">
        <button class="goBackbtn" onclick="window.location.href='homepage.php'">
            <i class="bi bi-arrow-left"></i>

        </button>

        <button class="passwordBtn" onclick="window.location.href='changePassword.php'">
            <i class="bi bi-lock"></i>
        </button>

        <div class=" cover"></div>

        <div class="avatar-container">
            <img class="profile_image" src="uploads/<?php echo $user['profile_image']; ?>">
        </div>

        <div class="profile-body">
            <h2><?= $user['name']; ?></h2>
            <p></p>

            <div class="info">
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span><?= $user['email']; ?></span>
                </div>
            </div>

            <div class="button-group">
                <a href="editProfile.php" class="edit">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profile
                </a>

                <a href="logout.php" class="logout">
                    <i class="bi bi-box-arrow-right"></i>
                    Log Out
                </a>
            </div>


        </div>
    </div>

    <script></script>

</body>

</html>