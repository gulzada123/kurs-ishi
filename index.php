<?php
session_start();
require_once "db_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Rasm yuklash
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $userId = $_SESSION['user_id'];
    $fileName = basename($_FILES["image"]["name"]);
    $uploadPath = __DIR__ . '/uploads/' . $fileName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);

    $stmt = $conn->prepare("INSERT INTO images (user_id, image_path) VALUES (?, ?)");
    $stmt->execute([$userId, $fileName]);
}

// Rasmlarni olish
$images = $conn->query("SELECT images.*, users.user_name FROM images JOIN users ON images.user_id = users.id ORDER BY images.id DESC");
?>

<h2>Rasm yuklash</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <button type="submit">Yuklash</button>
    <link rel="stylesheet" href="./css/index.css">
</form>
<div style="text-align: right; margin-bottom: 20px;">
    <a href="logout.php" style="text-decoration:none; color:white; background-color:#d32f2f; padding:10px 15px; border-radius:8px;">Logout</a>
</div>

<hr>

<h2>Rasmlar</h2>
<?php while ($row = $images->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="image-card">
        <strong><?= htmlspecialchars($row['user_name']) ?></strong>
        <img src="<?= '/Image_uz/uploads/'. $row['image_path']; ?>" width="200"><br><br>

        <form method="POST" action="like.php" style="display:inline;">
            <input type="hidden" name="image_id" value="<?= $row['id'] ?>">
            <button type="submit">Like</button>
        </form>

        <form method="POST" action="comment.php" style="display:inline;">
            <input type="hidden" name="image_id" value="<?= $row['id'] ?>">
            <input type="text" name="comment" placeholder="Komment...">
            <button type="submit">Yuborish</button>
        </form>
    </div>

<?php endwhile; ?>

