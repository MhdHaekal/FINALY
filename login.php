<?php
session_start();
require_once 'config/db.php'; // Koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cari pengguna berdasarkan email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data pengguna ke dalam session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: admin/admin_dashboard.php"); // Redirect ke halaman admin
        } else {
            header("Location: user/home.php"); // Redirect ke halaman user
        }
        exit();
    } else {
        echo "Email atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Course Online</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Colors */
        :root {
            --primary-color: #0064b5;
            --secondary-color: #00467f;
            --third-color: #bfe2ff;
        }

        body {
            background-color: var(--third-color);
        }

        .container {
            max-width: 400px;
            margin-top: 50px;
        }

        .card {
            border: 1px solid var(--primary-color);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .form-control {
            border-color: var(--primary-color);
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 71, 127, 0.25);
        }

        h2 {
            color: var(--primary-color);
        }

        .alert {
            background-color: var(--secondary-color);
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Login</h3>
        </div>
        <div class="card-body">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <!-- Error message -->
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$user): ?>
        <div class="alert mt-3">
            <p>Email atau password salah.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
