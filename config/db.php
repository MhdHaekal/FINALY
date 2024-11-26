<?php
$host = 'localhost';  // Or your database host
$username = 'root';   // Your database username
$password = '';       // Your database password
$dbname = 'course_online';  // Your database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode untuk menampilkan exception jika terjadi kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    exit;
}
// Create connection
$db = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
