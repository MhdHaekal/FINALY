<?php
session_start();
require_once '../config/db.php';

// Pastikan ada parameter course_id di URL
if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    die("Invalid course ID.");
}

$course_id = $_GET['course_id'];

// Ambil detail kursus berdasarkan ID
$query = "SELECT * FROM courses WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_result = $stmt->get_result();

if ($course_result->num_rows === 0) {
    die("Course not found.");
}

$course = $course_result->fetch_assoc();

// Ambil semua materi kursus
$content_query = "SELECT * FROM course_content WHERE course_id = ?";
$content_stmt = $db->prepare($content_query);
$content_stmt->bind_param("i", $course_id);
$content_stmt->execute();
$content_result = $content_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Detail - <?= $course['title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2><?= $course['title'] ?></h2>
        <p><?= $course['description'] ?></p>

        <h4>Course Content</h4>
        <div class="list-group">
            <?php while ($content = $content_result->fetch_assoc()) { ?>
                <a href="<?= $content['content_url'] ?>" class="list-group-item list-group-item-action" target="_blank">
                    <?= ucfirst($content['content_type']) ?> - <?= basename($content['content_url']) ?>
                </a>
            <?php } ?>
        </div>

        <a href="home.php" class="btn btn-secondary mt-3">Back to Homepage</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
