<?php
session_start();

$conn = new mysqli("localhost", "root", "", "mindease");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("Invalid Appointment");
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT * FROM appointments
    WHERE appointment_id = ? AND user_id = ?
");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Appointment not found.");
}

$row = $result->fetch_assoc();

$message = "";

if (isset($_POST['update'])) {

    $therapist = $_POST['therapist'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    if ($date < date("Y-m-d")) {

        $message = "<div class='alert alert-danger'>Past dates are not allowed.</div>";
    } else {

        // Check if another appointment already uses this slot
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

        if ($check->get_result()->num_rows > 0) {

            $message = "<div class='alert alert-danger'>This time slot is unavailable.</div>";
        } else {

            $update = $conn->prepare("
                UPDATE appointments
                SET therapist_name = ?,
                    appointment_date = ?,
                    appointment_time = ?,
                    session_type = ?,
                    notes = ?
                WHERE appointment_id = ?
            ");

            $update->bind_param(
                "sssssi",
                $therapist,
                $date,
                $time,
                $type,
                $notes,
                $id
            );

            if ($update->execute()) {

                header("Location: viewappointment.php");
                exit();
            } else {

                $message = "<div class='alert alert-danger'>Update failed.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Edit Appointment</title>

    <link rel="stylesheet" href="appointment.css">

    <link rel="icon" href="images/favicon.ico">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <div class="form-container">

        <div class="emotion happy">
            <i class="bi bi-pencil-square"></i>
        </div>

        <div class="emotion sad">
            <i class="bi bi-calendar-heart"></i>
        </div>

        <a href="viewappointment.php" class="goBackbtn">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2>Edit Appointment</h2>

        <?= $message; ?>

        <form method="POST">

            <div class="input-group">

                <label>Therapist</label>

                <select
                    name="therapist"
                    id="therapist"
                    onchange="loadSlots()">

                    <option value="Emily Carter"
                        <?= ($row['therapist_name'] == "Emily Carter") ? "selected" : ""; ?>>
                        Emily Carter
                    </option>

                    <option value="Michael Brown"
                        <?= ($row['therapist_name'] == "Michael Brown") ? "selected" : ""; ?>>
                        Michael Brown
                    </option>

                    <option value="Sophia Wilson"
                        <?= ($row['therapist_name'] == "Sophia Wilson") ? "selected" : ""; ?>>
                        Sophia Wilson
                    </option>

                </select>

            </div>

            <div class="input-group">

                <label>Session Type</label>

                <select name="type">

                    <option
                        <?= ($row['session_type'] == "Online") ? "selected" : ""; ?>>
                        Online
                    </option>

                    <option
                        <?= ($row['session_type'] == "Face-to-Face") ? "selected" : ""; ?>>
                        Face-to-Face
                    </option>

                </select>

            </div>

            <div class="input-group">

                <label>Date</label>

                <input
                    type="date"
                    id="date"
                    name="date"
                    value="<?= $row['appointment_date']; ?>"
                    onchange="loadSlots()"
                    required>

            </div>

            <div class="input-group">

                <label>Available Time</label>

                <select
                    name="time"
                    id="time"
                    required>

                    <option>Loading...</option>

                </select>

            </div>

            <div class="input-group">

                <label>Notes</label>

                <textarea
                    name="notes"
                    rows="4"><?= htmlspecialchars($row['notes']); ?></textarea>

            </div>

            <div class="button-group">

                <button
                    type="submit"
                    name="update"
                    class="bookBtn">

                    Update

                </button>

                <a
                    href="viewappointment.php"
                    class="viewAppointmentBtn text-center text-decoration-none">

                    Back

                </a>

            </div>

        </form>

    </div>

    <script>
        function loadSlots() {

            let therapist =
                document.getElementById("therapist").value;

            let date =
                document.getElementById("date").value;

            if (date == "") {
                return;
            }

            fetch(
                    "editSlots.php?id=<?= $id ?>&date=" +
                    date +
                    "&therapist=" +
                    encodeURIComponent(therapist)
                )

                .then(response => response.text())

                .then(data => {

                    document.getElementById("time").innerHTML = data;

                    let currentTime = "<?= $row['appointment_time']; ?>";

                    let options =
                        document.querySelectorAll("#time option");

                    options.forEach(function(option) {

                        if (option.value == currentTime) {

                            option.selected = true;

                        }

                    });

                });

        }

        window.onload = function() {

            loadSlots();

        };
    </script>

</body>

</html>