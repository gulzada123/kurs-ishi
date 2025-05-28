<?php
session_start();
require_once 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['first_name'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Email yoki parol noto‘g‘ri!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kirish</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
<div class="form-container">
    <h2>Kirish</h2>
    <?php 
    if (isset($_SESSION['already_registered'])) {
        echo "<p class='success'>" . $_SESSION['already_registered'] . "</p>";
        unset($_SESSION['already_registered']);
    }
    if (isset($error)) echo "<p class='error'>$error</p>";
    ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Parol" required><br>
        <button type="submit">Kirish</button>
    </form>
    <p>Yangi foydalanuvchimisiz? <a href="register.php">Ro‘yxatdan o‘tish</a></p>
</div>
</body>
</html>
