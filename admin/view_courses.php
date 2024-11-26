<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$stmt = $pdo->query("SELECT c.id, c.title, c.description, c.created_at, u.full_name AS instructor 
                     FROM courses c
                     LEFT JOIN users u ON c.instructor_id = u.id");
$courses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-primary">Data Course</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td><?php echo htmlspecialchars($course['description']); ?></td>
                    <td><?php echo htmlspecialchars($course['instructor'] ?: 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($course['created_at']); ?></td>
                    <td>
                        <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_course.php?id=<?php echo $course['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>
</body>
</html>
