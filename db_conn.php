<?php
$host = 'localhost';
$db = 'rasmlar';
$user = 'root'; // yoki real foydalanuvchi
$pass = '';     // parolingiz bo‘lsa yozing
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ulanishda xatolik: " . $e->getMessage());
}
?>
