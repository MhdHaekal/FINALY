<?php
session_start();
require_once '../config/db.php';

// Fetch all courses from the database
$query = "SELECT * FROM courses";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #0064b5;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link:hover {
            color: #d1d1d1;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
        .footer a {
            color: #0064b5;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="homepage_user.php">Course Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage_user.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item">
                            <a class="nav-item"><a class="nav-link" href="../logout.php">Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2>Available Courses</h2>
        <div class="row">
            <?php while ($course = $result->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= $course['image_url'] ?>" class="card-img-top" alt="Course Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                            <p class="card-text"><?= substr(htmlspecialchars($course['description']), 0, 100) ?>...</p>
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <!-- Display buttons for logged-in users -->
                                <a href="course_details.php?course_id=<?= $course['id'] ?>" class="btn btn-primary">View Course</a>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-primary">Login to View</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Contact Us Section -->
    <div class="container mt-5" id="contact">
        <h3>Contact Us</h3>
        <p>If you have any questions or need support, feel free to reach out to us:</p>
        <ul>
            <li>Email: <a href="mailto:support@courseportal.com">support@courseportal.com</a></li>
            <li>Phone: +123 456 7890</li>
            <li>Address: 123 Course Street, Education City, Country</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 Course Portal. All Rights Reserved.</p>
        <p><a href="privacy_policy.php">Privacy Policy</a> | <a href="terms_of_service.php">Terms of Service</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
