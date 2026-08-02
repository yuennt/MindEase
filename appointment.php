<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$database = "mindease";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$selectedTherapist = "";

if (isset($_GET['therapist'])) {
    $selectedTherapist = $_GET['therapist'];
}

if (isset($_POST['book'])) {
    $therapist = $_POST['therapist'];
    $session_type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    // Prevent booking previous dates
    if ($date < date("Y-m-d")) {

        $message = "<div class='alert alert-danger'>Past dates are not allowed.</div>";
    } else {

        // Check if therapist already booked
        $check = $conn->prepare("SELECT * FROM appointments
        WHERE therapist_name=? 
        AND appointment_date=? 
        AND appointment_time=?
        AND status!='Cancelled'");

        $check->bind_param("sss", $therapist, $date, $time);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "<div class='alert alert-danger'>This time slot has already been booked.</div>";
        } else {

            $insert = $conn->prepare("INSERT INTO appointments
            (user_id,therapist_name,appointment_date,appointment_time,session_type,notes)
            VALUES(?,?,?,?,?,?)");

            $insert->bind_param(
                "isssss",
                $user_id,
                $therapist,
                $date,
                $time,
                $session_type,
                $notes
            );

            if ($insert->execute()) {

                $message = "<div class='alert alert-success'>Appointment booked successfully!</div>";
            } else {

                $message = "<div class='alert alert-danger'>Booking Failed! Please try again</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="appointment.css">

    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<body>

    <div class="form-container">
        <div class="emotion happy">
            <i class="bi bi-emoji-smile"></i>
        </div>

        <div class="emotion sad">
            <i class="bi bi-calendar-heart"></i>
        </div>

        <a href="homepage.php" class="goBackbtn">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2>Book Appointment</h2>

        <?php echo $message; ?>
        <form method="POST">
            <div class="input-group">
                <label>Therapist</label>
                <select name="therapist" onchange="loadSlots()" required>
                    <option value="Emily Carter" <?= ($selectedTherapist == "Emily Carter") ? "selected" : ""; ?>>Emily Carter</option>
                    <option value="Michael Brown" <?= ($selectedTherapist == "Michael Brown") ? "selected" : ""; ?>>Michael Brown</option>
                    <option value="Sophia Wilson" <?= ($selectedTherapist == "Sophia Wilson") ? "selected" : ""; ?>>Sophia Wilson</option>
                </select>

            </div>

            <div class="input-group">
                <label>Session Type</label>
                <select name="type">
                    <option>Online</option>
                    <option>Face-to-Face</option>
                </select>

            </div>

            <div class="input-group">
                <label>Date</label>
                <input type="date" name="date" id="date" required onchange="loadSlots()">
            </div>

            <div class="input-group">
                <label>Available Time</label>
                <select type="time" id="time" name="time" required>
                    <option>Select Time</option>
                </select>
            </div>

            <div class="input-group">
                <label>Notes</label>
                <textarea name="notes"></textarea>
            </div>

            <div class="button-group">
                <button type="submit" name="book" class="bookBtn">
                    Book
                </button>

                <a href="viewappointment.php" class="viewAppointmentBtn text-center text-decoration-none">
                    View
                </a>

            </div>

        </form>

    </div>

</body>

<script>
    function loadSlots() {

        let date = document.getElementById("date").value;

        let therapist =
            document.querySelector("select[name='therapist']").value;

        if (date == "") {
            return;
        }

        fetch(
                "getslots.php?date=" + date +
                "&therapist=" + therapist
            )

            .then(response => response.text())

            .then(data => {

                document.getElementById("time").innerHTML = data;

            })

            .catch(error => {
                console.log(error);
            });


    }
</script>

</html>