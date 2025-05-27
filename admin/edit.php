<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) { die("Brak ID."); }

$stmt = $pdo->prepare("SELECT * FROM images WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch();

if (!$image) { die("Obraz nie istnieje."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keywords = $_POST['keywords'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE images SET keywords = ?, category = ? WHERE id = ?");
    $stmt->execute([$keywords, $category, $id]);

    header("Location: manage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj obraz</title>
</head>
<body>

<h2>Edytuj obraz</h2>

<form method="post">
    <p><strong>Plik:</strong> <?php echo htmlspecialchars($image['filename']); ?></p>
    <label>Kategoria:</label>
    <input type="text" name="category" value="<?php echo htmlspecialchars($image['category']); ?>" required><br><br>
    <label>Słowa kluczowe:</label>
    <textarea name="keywords" rows="3" required><?php echo htmlspecialchars($image['keywords']); ?></textarea><br><br>
    <button type="submit">Zapisz</button>
</form>

</body>
</html>
