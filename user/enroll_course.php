<?php
session_start();
require_once '../config/db.php';

// Pastikan pengguna login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $user_id = $_SESSION['user_id'];

    // Periksa apakah pengguna sudah terdaftar untuk kursus ini
    $query_check = "SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?";
    $stmt_check = $db->prepare($query_check);
    $stmt_check->bind_param("i", $user_id, $course_id);
    $stmt_check->execute();
    $existing_enrollment = $stmt_check->get_result()->num_rows;

    if ($existing_enrollment == 0) {
        // Jika belum terdaftar, tambahkan ke tabel enrollments
        $query_enroll = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
        $stmt_enroll = $db->prepare($query_enroll);
        $stmt_enroll->bind_param("ii", $user_id, $course_id);
        if ($stmt_enroll->execute()) {
            $_SESSION['success'] = "Anda berhasil mendaftar untuk kursus ini!";
        } else {
            $_SESSION['error'] = "Gagal mendaftar untuk kursus.";
        }
    } else {
        $_SESSION['info'] = "Anda sudah terdaftar di kursus ini.";
    }

    header("Location: course_detail.php?course_id=" . $course_id);
    exit();
}
?>
