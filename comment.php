<?php
session_start();
require_once "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $imageId = $_POST['image_id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (user_id, image_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $imageId, $comment]);
}

header("Location: index.php");
exit();
?>
