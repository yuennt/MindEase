<?php

$conn = new mysqli("localhost", "root", "", "mindease");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$date = $_GET['date'];
$therapist = $_GET['therapist'];

// Fixed daily schedule
$slots = [];

switch ($therapist) {

    case "Emily Carter":
        $slots = ["09:00:00", "10:00:00", "11:00:00"];
        break;

    case "Michael Brown":
        $slots = ["14:00:00", "15:00:00", "16:00:00"];
        break;

    case "Sophia Wilson":
        $slots = ["09:00:00", "13:00:00", "15:00:00"];
        break;
}

foreach ($slots as $time) {

    $check = $conn->prepare("
        SELECT appointment_id
        FROM appointments
        WHERE therapist_name = ?
        AND appointment_date = ?
        AND appointment_time = ?
        AND appointment_id <> ?
        AND status != 'Cancelled'
    ");

    $check->bind_param("sssi", $therapist, $date, $time, $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {

        echo "<option value='$time' disabled>$time - Unavailable</option>";
    } else {

        echo "<option value='$time'>$time - Available</option>";
    }
}
