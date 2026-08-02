<?php
session_start();

$conn = new mysqli("localhost", "root", "", "mindease");

if ($conn->connect_error) {
    die("Database Connection Failed");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT *
        FROM appointments
        WHERE user_id=?
        ORDER BY created_at ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Appointment</title>

    <link rel="stylesheet" href="appointmentStyle.css">
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container-box">
        <div class="emotion happy">
            <i class="bi bi-emoji-smile"></i>
        </div>

        <div class="emotion sad">
            <i class="bi bi-calendar-heart"></i>
        </div>

        <a href="homepage.php" class="goBackbtn">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2>My Appointments</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Therapist</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Session</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $number = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?= $number++; ?></td>
                                <td><?= $row['therapist_name']; ?></td>
                                <td><?= date("d M Y", strtotime($row['appointment_date'])); ?></td>
                                <td><?= date("g:i A", strtotime($row['appointment_time'])); ?></td>
                                <td><?= $row['session_type']; ?></td>

                                <td>
                                    <span class="status <?= strtolower($row['status']); ?>">
                                        <?= $row['status']; ?>
                                    </span>
                                </td>

                                <td><?= $row['notes']; ?></td>

                                <td>
                                    <?php if ($row['status'] == "Pending") { ?>

                                        <a class="btn-edit" href="editAppointment.php?id=<?= $row['appointment_id']; ?>">
                                            Edit
                                        </a>

                                        <a class="btn-cancel" href="cancelAppointment.php?id=<?= $row['appointment_id']; ?>" onclick="return confirm('Cancel this appointment?')">
                                            Cancel
                                        </a>

                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                        }
                    } else { ?>

                        <tr>
                            <td colspan="8" class="empty">
                                No appointments found.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="bookBtn">
                <a href="appointment.php">Book Now</a>
            </div>
        </div>
    </div>
</body>

</html>