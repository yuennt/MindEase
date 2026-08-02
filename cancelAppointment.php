<?php

$conn = new mysqli("localhost", "root", "", "mindease");

$id = $_GET['id'];

$conn->query("UPDATE appointments
SET status='Cancelled'
WHERE appointment_id='$id'");

header("Location:viewAppointment.php");
