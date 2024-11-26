<?php
session_start();
require_once '../config/db.php';

// Pastikan hanya admin yang dapat mengakses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-primary: #0064b5;
            --bs-secondary: #00467f;
            --bs-info: #bfe2ff;
        }
        .card-header {
            background-color: var(--bs-primary);
            color: #ffffff;
        }
        .card-body {
            background-color: var(--bs-info);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--bs-primary);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        <h1 class="text-primary">Selamat Datang, Admin!</h1>
        <p class="lead">Pilih menu di bawah untuk mengelola data course dan pengguna.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Tambah Course</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Tambah course baru untuk platform belajar Anda.</p>
                        <a href="add_course.php" class="btn btn-primary">Tambah Course</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Lihat Data Course</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Lihat dan kelola course yang sudah ditambahkan.</p>
                        <a href="view_courses.php" class="btn btn-primary">Lihat Courses</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Lihat Data User</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Lihat semua pengguna yang terdaftar di platform Anda.</p>
                        <a href="view_users.php" class="btn btn-primary">Lihat Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
