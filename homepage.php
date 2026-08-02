<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$username = "Guest";

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MindEase</title>

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="aichat.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Social Media Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            width: 100%;
            overflow-x: hidden;
            background: black;
            color: #222;
        }
    </style>
</head>

<body>
    <!-- Homepage -->
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="images/mindEase.png" alt="MindEase">
                <p>Mind</p>
                <span>Ease</span>
            </a>

            <!-- Center Menu -->
            <div class="navbar-container">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#expertise">Expertise</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>

            <!-- Right Icons -->
            <div class="navbar2">
                <a href="#" class="assessment-icon" onclick="window.location.href='moodAnalysis.php'">
                    <i class="bi bi-activity"></i>
                </a>

                <a href="profile.php" class="profile-link">
                    <i class="bi bi-person-circle"></i>

                    <span class="user-name">
                        Welcome! <?= htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <!-- First Section-->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content"></div>
            <h1>AI Mental Health Wellbeing Platform</h1>

            <p>Improve your emotional wellbeing with AI-powered support, therapy tracking, mindfulness exercises, and
                professional guidance.</p>

            <div class="hero-btn">
                <a href="#" class="getStartedBtn" onclick="window.location.href='register.php'">Get Started</a>
            </div>
        </div>
        </div>
    </section>

    <!-- Our Services -->
    <section class="services-section" id="services">
        <div class="services-header">
            <div class="services-overlay">
                <h2>Our Services</h2>
                <p>We provide professional mental health support to help improve emotional well-being and personal
                    growth</p>
            </div>
        </div>

        <div class="services-content">
            <div class="services-card">
                <i class="fas fa-user-doctor"></i>
                <h3>Therapy Session</h3>
                <p>Book confidential one-to-one counselling sessions with licensed therapists to manage anxiety,
                    depression, stress, and emotional wellbeing</p>
            </div>

            <div class="services-card">
                <i class="fas fa-clipboard-list"></i>
                <h3>Mood Analysis</h3>
                <p>Track your mood and emotions over time with our AI-powered mood analysis tool to gain insights
                    into your mental health patterns</p>
            </div>

            <div class="services-card">
                <i class="fas fa-comment"></i>
                <h3>AI Chat Assistant </h3>
                <p>Chat with our intelligent virtual assistant anytime for
                    emotional support, mindfulness exercises, self-care tips,
                    and mental health guidance</p>
            </div>

            <div class="services-card">
                <i class="fas fa-heartbeat"></i>
                <h3>Treatment Plans</h3>
                <p>Receive personalized treatment plans tailored to your specific mental health needs and goals</p>
            </div>
        </div>
    </section>

    <!-- Our Expertise -->
    <section class="expertise-section" id="expertise">
        <div class="container">
            <div class="section-title">
                <h2>Our Expertise</h2>
                <p>Meet our professionals dedicated to your growth and wellbeing</p>
            </div>

            <div class="expertise-grid">
                <!-- Expert 1 -->
                <div class="expert-card">
                    <div class="expert-img">
                        <img src="images/doctor1.png" alt="">
                    </div>

                    <h3 class="expert-name">Emily Carter</h3>

                    <div class="expert-role">
                        Senior Mental Health Therapist
                    </div>


                    <p class="expert-desc">
                        At MindBalance Mental Health Center, we believe that mental well-being is the foundation of a
                        fulfilling life. We support individuals facing anxiety, depression, stress, and personal growth
                        challenges
                    </p>

                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>


                    <div class="tags">
                        <span>Anxiety</span>
                        <span>Depression</span>
                        <span>Stress Management</span>
                        <span>Personal Growth</span>
                    </div>

                    <button class="bookbtn" onclick="window.location.href='appointment.php?therapist=Emily Carter'">Book Now</button>
                </div>


                <!-- Expert 2 -->
                <div class="expert-card">
                    <div class="expert-img">
                        <img src="images/doctor2.jpg" alt="">
                    </div>

                    <h3 class="expert-name">Michael Brown</h3>

                    <div class="expert-role">
                        Clinical Psychologist
                    </div>


                    <p class="expert-desc">
                        Helping clients understand emotions, develop resilience, and improve mental wellness through
                        evidence-based therapy and compassionate care
                    </p>


                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-alt"></i>
                    </div>


                    <div class="tags">
                        <span>Trauma</span>
                        <span>CBT</span>
                        <span>Relationships</span>
                        <span>Mindfulness</span>
                    </div>

                    <button class="bookbtn" onclick="window.location.href='appointment.php?therapist=Michael Brown'">Book Now</button>
                </div>

                <!-- Expert 3 -->
                <div class="expert-card">
                    <div class="expert-img">
                        <img src="images/doctor3.png" alt="">
                    </div>

                    <h3 class="expert-name">Sophia Wilson</h3>

                    <div class="expert-role">
                        Wellness Counselor
                    </div>

                    <p class="expert-desc">
                        Dedicated to helping individuals achieve balance, confidence, and healthier lifestyles through
                        professional counseling and coaching
                    </p>

                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>

                    <div class="tags">
                        <span>Coaching</span>
                        <span>Self-Esteem</span>
                        <span>Wellness</span>
                        <span>Life Skills</span>
                    </div>

                    <button class="bookbtn" onclick="window.location.href='appointment.php?therapist=Sophia Wilson'">Book Now</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonial-section" id="testimonials">
        <div class="testimonial-container">

            <div class="section-title">
                <h2>What Patients Say</h2>
            </div>

            <div class="testimonial-content">
                <div class="testimonial-card">
                    <i class="fa-solid fa-quote-left"></i>
                    <h3>Life Changing Support</h3>
                    <p>MindEase helped me manage my stress and anxiety through
                        professional guidance and practical techniques. I feel
                        much more confident and balanced now</p>
                    <h6>Sarah Lee</h6>
                </div>

                <div class="testimonial-card">
                    <i class="fa-solid fa-quote-left"></i>
                    <h3>Highly Recommended</h3>
                    <p>The counselors were understanding and supportive.
                        The sessions gave me the tools I needed to improve my mental well-being and daily routine</p>
                    <h6>Daniel Wong</h6>
                </div>

                <div class="testimonial-card">
                    <i class="fa-solid fa-quote-left"></i>
                    <h3>Safe and Comfortable</h3>
                    <p>I appreciated the welcoming and professional approach. Every session felt meaningful and helped
                        me grow emotionally</p>
                    <h6>Aisha Karim</h6>
                </div>
            </div>
        </div>
    </section>


    <!-- footer section -->
    <footer>
        <div class="footer-container" id="contact">
            <!-- left -->
            <div class="footer-left">
                <a class="footer-brand" href="#">
                    <img src="images/mindEase.png" alt="MindEase" class="footer-logo">
                </a>

                <div class="footer-brand2" href="#">
                    Mind<span>Ease</span>
                </div>

                <div class="footer-brand3" href="#">
                    <p>
                        AI Mental Health Wellbeing
                    </p>
                </div>
            </div>

            <!-- center -->
            <div class="footer-center">
                <div class="footer-links">
                    <h1>Quick Links</h1>
                    <a href="#home">Home</a>
                    <a href="#services">Services</a>
                    <a href="#expertise">Expertise</a>
                    <a href="#testimonials">Testimonials</a>
                    <a href="#contact">Contact Us</a>
                </div>
            </div>


            <!-- right -->
            <div class="footer-right">
                <div class="footer-contact">
                    <h1>Contact Us</h1>
                    <p>4671 Sugar Camp Road, Owatonna, Minnesota, 55060</p>
                    <p>+6012-3456789</p>
                    <p>mindease@gmail.com</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>
                © 2026 MindEase: AI Mental Health Wellbeing Application | All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Floating Chat Widget -->
    <div class="chat-widget">

        <!-- Tooltip -->
        <div class="chat-tooltip">
            Chat with Us
        </div>

        <!-- Chat Button -->
        <div class="chat-button" id="chatBtn">
            <i class="bi bi-chat"></i>
        </div>

        <!-- Book Appoinment Button -->
        <div class="appointment-button" onclick="appointmentFunction()" id="appointmentBtn">
            <i class="bi bi-calendar-event"></i>
        </div>

        <!-- Scroll to Top Button -->
        <div class="arrow-up-button" onclick="topFunction()" id="scrollToTopBtn">
            <i class="bi bi-arrow-up"></i>
        </div>
    </div>

    <!-- Load AI Chat UI -->
    <?php include "aichat.php"; ?>

    <script>
        function booking() {
            window.location.href = "appointment.php";
        }

        function appointmentFunction() {
            // Redirect to book appoinment page or open appointment widget
            window.location.href = "appointment.php";
        }

        //Get the button
        var scrollToTopBtn = document.getElementById("scrollToTopBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const USER_EMAIL = "<?= $_SESSION['user_email']; ?>";
    </script>

    <script src="aichat.js"></script>

</body>

</html>
