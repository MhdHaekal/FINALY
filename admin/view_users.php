<?php
session_start();
require_once '../config/db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil semua data user
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        :root {
            --bs-primary: #0064b5;
            --bs-secondary: #00467f;
            --bs-info: #bfe2ff;
        }
        body {
            font-family: Arial, sans-serif;
        }
        table th, table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-primary">Users Registered</h2>
        <table id="usersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "language": {
                    "search": "Search Users:",
                    "paginate": {
                        "next": "Next",
                        "previous": "Previous"
                    },
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });
    </script>
</body>
</html>
