<?php

$conn = new mysqli("localhost", "root", "", "mindease");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = $_GET['date'];
$therapist = $_GET['therapist'];

// Fixed daily schedule for each therapist
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

if (empty($slots)) {
    echo "<option>No available time slots</option>";
    exit;
}

// Check each slot against existing appointments
foreach ($slots as $time) {

    $check = $conn->prepare("
        SELECT appointment_id
        FROM appointments
        WHERE therapist_name = ?
        AND appointment_date = ?
        AND appointment_time = ?
        AND status != 'Cancelled'
    ");

    $check->bind_param("sss", $therapist, $date, $time);
    $check->execute();
    $booked = $check->get_result();

    if ($booked->num_rows > 0) {

        echo "<option value='$time' disabled>$time - Unavailable</option>";
    } else {

        echo "<option value='$time'>$time - Available</option>";
    }
}
