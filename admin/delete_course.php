<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    try {
        // Start a transaction
        $pdo->beginTransaction();

        // First, delete related enrollments
        $stmt = $pdo->prepare("DELETE FROM enrollments WHERE course_id = ?");
        $stmt->execute([$_GET['id']]);

        // Delete related course content
        $stmt = $pdo->prepare("DELETE FROM course_content WHERE course_id = ?");
        $stmt->execute([$_GET['id']]);

        // Finally, delete the course
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$_GET['id']]);

        // Commit the transaction
        $pdo->commit();

        echo "Course and its related content successfully deleted.";
        header("Location: admin_dashboard.php");
        exit();
    } catch (Exception $e) {
        // Rollback if any error occurs
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
