<?php
session_start();
require_once "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $imageId = $_POST['image_id'];

    $check = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND image_id = ?");
    $check->execute([$userId, $imageId]);

    if ($check->rowCount() == 0) {
        $stmt = $conn->prepare("INSERT INTO likes (user_id, image_id) VALUES (?, ?)");
        $stmt->execute([$userId, $imageId]);
    }
}

header("Location: index.php");
exit();
?>
