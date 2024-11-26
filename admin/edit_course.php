<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("UPDATE courses SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $course_id]);

        echo "Course berhasil diperbarui.";
        header("Location: admin_dashboard.php");
        exit();
    }
} else {
    echo "Course ID not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
</head>
<body>
    <h2>Edit Course</h2>
    <form action="edit_course.php?id=<?php echo $course['id']; ?>" method="POST">
        <label for="title">Course Title:</label>
        <input type="text" name="title" value="<?php echo $course['title']; ?>" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $course['description']; ?></textarea><br>

        <button type="submit">Update Course</button>
    </form>
    <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</body>
</html>
