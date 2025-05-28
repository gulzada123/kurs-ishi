<?php
session_start();
require_once 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlentities($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fn = htmlentities($_POST['name']);
    $sn = htmlentities($_POST['sur_name']);

    // Email tekshirish
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $_SESSION['already_registered'] = "Bu email bilan allaqachon ro‘yxatdan o‘tilgan!";
        header("Location: login.php");
        exit();
    }

    // Foydalanuvchini qo‘shish
    $query = "INSERT INTO users(`email`, `password`, `first_name`, `second_name`) VALUES (?, ?, ?, ?)";
    $insert = $conn->prepare($query);
    $insert->execute([$email, $password, $fn, $sn]);

    $_SESSION['user_id'] = $conn->lastInsertId();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Ro‘yxatdan o‘tish</title>
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
<div class="form-container">
    <h2>Ro‘yxatdan o‘tish</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Ismingiz" required><br>
        <input type="text" name="sur_name" placeholder="Familiyangiz" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Parol" required><br>
        <button type="submit">Ro‘yxatdan o‘tish</button>
    </form>
    <p>Allaqachon ro‘yxatdan o‘tganmisiz? <a href="login.php">Kirish</a></p>
</div>
</body>
</html>
