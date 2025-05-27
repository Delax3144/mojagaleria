<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) { die("Brak ID."); }

$stmt = $pdo->prepare("SELECT filename FROM images WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch();

if ($image) {
    $file = $image['filename'];
    @unlink("../images/$file");
    @unlink("../thumbnails/$file");

    $del = $pdo->prepare("DELETE FROM images WHERE id = ?");
    $del->execute([$id]);
}

header("Location: manage.php");
exit;
