<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "mindease";
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

// Check connection
if (!$conn) {
	die("Database Connection Failed: " . mysqli_connect_error());
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get form values
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	// Empty validation
	if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
		echo "<script>alert('Please fill in all fields');
		window.location.href='register.php';
        </script>";

		exit();
	}

	// Name validation
	if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
		echo "<script>alert('Name can only contain letters');
        window.location.href='register.php';
        </script>";

		exit();
	}

	// Email validation
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<script>alert('Invalid email address');
		window.location.href='register.php';
        </script>";

		exit();
	}

	// Password length validation
	if (strlen($password) < 6) {
		echo "<script>alert('Password must contain at least 6 characters');
        window.location.href='register.php';
        </script>";

		exit();
	}

	// Confirm password validation
	if ($password !== $confirm_password) {
		echo "<script>alert('Password and Confirm Password do not match');
        window.location.href='register.php';
        </script>";

		exit();
	}

	// Check existing email
	$check = $conn->prepare(
		"SELECT email FROM user WHERE email=?"
	);

	$check->bind_param(
		"s",
		$email
	);

	$check->execute();
	$result = $check->get_result();

	if ($result->num_rows > 0) {
		echo "<script>alert('Email already registered');
        window.location.href='register.php';
        </script>";

		exit();
	}

	// Insert user into database
	$insert = $conn->prepare(
		"INSERT INTO user
        (name,email,password,confirmPassword)
        VALUES(?,?,?,?)"
	);


	$insert->bind_param(
		"ssss",
		$name,
		$email,
		$password,
		$confirm_password
	);

	if ($insert->execute()) {
		echo "<script>alert('Registration Successful!');
        window.location.href='signIn.php';
        </script>";
	} else {
		echo "<script>alert('Registration Failed');
        window.location.href='register.php';
        </script>";
	}

	$insert->close();
	$check->close();
}


mysqli_close($conn);
