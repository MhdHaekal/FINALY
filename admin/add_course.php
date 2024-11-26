<?php
session_start();
require_once '../config/db.php';  // Ensure db.php is included and provides a connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor_id = $_SESSION['user_id'];

    // Pastikan folder assets/images/ dan assets/files/ tersedia
    $image_dir = "../assets/images/";
    $file_dir = "../assets/files/";

    // Create the directories if they don't exist
    if (!is_dir($image_dir)) {
        mkdir($image_dir, 0777, true);
    }
    if (!is_dir($file_dir)) {
        mkdir($file_dir, 0777, true);
    }

    // Upload course image
    $image_path = null; // Default to null in case no image is uploaded
    if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] == 0) {
        $image_name = $_FILES['course_image']['name'];
        $image_path = $image_dir . $image_name;
        move_uploaded_file($_FILES['course_image']['tmp_name'], $image_path);
    }

    // Upload content file (if any)
    $file_path = null; // Default to null in case no content file is uploaded
    if (isset($_FILES['content_file']) && $_FILES['content_file']['error'] == 0) {
        $file_name = $_FILES['content_file']['name'];
        $file_path = $file_dir . $file_name;
        move_uploaded_file($_FILES['content_file']['tmp_name'], $file_path);
    }

    // Insert course data into the database
    $query = "INSERT INTO courses (title, description, image_url, instructor_id) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        die("Error preparing the statement: " . $db->error);
    }
    $stmt->bind_param("sssi", $title, $description, $image_path, $instructor_id);

    if ($stmt->execute()) {
        $course_id = $stmt->insert_id;

        // If there is content to add
        if (!empty($_POST['content_title']) && !empty($_POST['content_type'])) {
            $content_title = $_POST['content_title'];
            $content_type = $_POST['content_type'];

            $query = "INSERT INTO course_content (course_id, content_type, content_url) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            if ($stmt === false) {
                die("Error preparing the statement: " . $db->error);
            }
            $stmt->bind_param("iss", $course_id, $content_type, $file_path);
            $stmt->execute();
        }
        $_SESSION['success'] = "Course berhasil ditambahkan.";
    } else {
        $_SESSION['error'] = "Gagal menambahkan course.";
    }

    // Redirect back to the form
    header("Location: add_course.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        :root {
            --bs-primary: #0064b5;
            --bs-secondary: #00467f;
            --bs-info: #bfe2ff;
        }
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .navbar {
            background-color: var(--bs-primary);
        }
        .form-label {
            color: var(--bs-primary);
        }
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        .btn-primary:hover {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: var(--bs-primary);">
                        <h4 class="mb-0">Add New Course</h4>
                    </div>
                    <div class="card-body">
                        <form action="add_course.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Course Title:</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <hr>
                            <h5 class="text-secondary">Add Content</h5>
                            <div class="mb-3">
                                <label for="content_title" class="form-label">Content Title:</label>
                                <input type="text" name="content_title" id="content_title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="content_type" class="form-label">Content Type:</label>
                                <select name="content_type" id="content_type" class="form-select">
                                    <option value="video">Video</option>
                                    <option value="pdf">PDF</option>
                                    <option value="presentation">Presentation</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="content_file" class="form-label">Upload File:</label>
                                <input type="file" name="content_file" id="content_file" class="form-control">
                            </div>
                            <hr>
                            <h5 class="text-secondary">Upload Course Image</h5>
                            <div class="mb-3">
                                <label for="course_image" class="form-label">Course Image:</label>
                                <input type="file" name="course_image" id="course_image" class="form-control">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Add Course</button>
                                <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
