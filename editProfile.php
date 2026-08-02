<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "mindease");

if (!$conn) {
    die("Connection Failed");
}

if (!isset($_SESSION['user_email'])) {
    header("Location: signIn.php");
    exit();
}

$email = $_SESSION['user_email'];

$sql = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $newEmail = trim($_POST['email']);
    $imageName = $user['profile_image'];

    // Upload profile image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {

        $folder = "uploads/";

        // create folder if not exist
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        $imageName = time() . "_" . basename($_FILES['profile_image']['name']);
        $target = $folder . $imageName;


        move_uploaded_file(
            $_FILES['profile_image']['tmp_name'],
            $target
        );
    }


    $update = "UPDATE user SET
                name=?,
                email=?,
                profile_image=?
                WHERE user_id=?";


    $stmt = $conn->prepare($update);


    $stmt->bind_param(
        "sssi",
        $name,
        $newEmail,
        $imageName,
        $user['user_id']
    );


    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $newEmail;


        echo "
        <script>
        alert('Profile Updated Successfully');
        window.location='profile.php';
        </script>";
    } else {

        echo "
        <script>
        alert('Update Failed');
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
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

        .form-container {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.4);
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }

        h2 {
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .avatar-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #666363;
        }

        .avatar-section input {
            margin-top: 15px;
            font-size: 12px;
            display: flex;
            margin-left: 65px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-left: 8px;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            /*letter-spacing: 2px;*/
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 12px;
            border: 3px solid rgb(171, 164, 164);
            background: rgba(255, 255, 255, 0.25);
            /*border-bottom: 2px solid #a6a3a3;*/
            border-radius: 15px;
            margin-bottom: 12px;
            outline: none;
            transition: 0.1s;
        }

        .form-group input,
        textarea:hover {
            border: 3px solid #666;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .saveBtn,
        .cancelBtn {
            width: 50%;
            padding: 14px;
            border: none;
            background: #b58422;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 15px;
            cursor: pointer;
            margin-top: 10px;
            left: 85px;
            transition: 0.2s;
        }

        .saveBtn:hover {
            background: #a97d2e;
            color: white;
            opacity: 0.9;
            transform: scale(1.05);
        }

        .cancelBtn:hover {
            background: #a97d2e;
            color: white;
            opacity: 0.9;
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Edit Profile</h2>

        <form method="POST" enctype="multipart/form-data">

            <div class="avatar-section">
                <img id="avatarPreview" class="avatar" src="uploads/<?php echo $user['profile_image']; ?>">
                <input type="file" id="avatarInput" name="profile_image" accept="image/*">
            </div>

            <div class="form-group">

                <label>Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo $user['name']; ?>"
                    required>

                <label>Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo $user['email']; ?>"
                    required>

            </div>

            <div class="button-group">

                <button
                    type="submit"
                    name="update"
                    class="saveBtn">
                    Save Changes
                </button>

                <button
                    type="button"
                    class="cancelBtn"
                    onclick="window.location.href='profile.php'">
                    Cancel
                </button>

            </div>

        </form>

    </div>

    <script>
        const avatarInput = document.getElementById("avatarInput");
        const avatarPreview = document.getElementById("avatarPreview");

        avatarInput.addEventListener("change", function() {

            const file = this.files[0];

            if (file) {

                const reader = new FileReader();

                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });



        function cancel() {
            window.location.href = "profile.php";
        }
    </script>
</body>

</html>