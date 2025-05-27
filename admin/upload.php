<?php require_once '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj obrazek</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form { max-width: 400px; margin: auto; }
        input, textarea, select { width: 100%; margin-bottom: 10px; padding: 8px; }
    </style>
</head>
<body>

<h2>Dodaj obrazek do galerii</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <label>Wybierz plik (JPG/PNG):</label>
    <input type="file" name="image" accept=".jpg,.jpeg,.png" required>

    <label>Słowa kluczowe:</label>
    <textarea name="keywords" rows="3" placeholder="np. krajobraz, natura" required></textarea>

    <label>Kategoria:</label>
    <input type="text" name="category" placeholder="np. Fotografia, Midjourney" required>

    <button type="submit" name="upload">Prześlij</button>
</form>

<?php
if (isset($_POST['upload'])) {
    $keywords = $_POST['keywords'];
    $category = $_POST['category'];
    $image = $_FILES['image'];

    $allowed = ['image/jpeg', 'image/png'];
    if (in_array($image['type'], $allowed)) {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newName = uniqid() . '.' . $ext;

        $uploadDir = '../images/';
        $thumbDir = '../thumbnails/';
        move_uploaded_file($image['tmp_name'], $uploadDir . $newName);

        // Tworzenie miniatury
        $sourcePath = $uploadDir . $newName;
        $thumbPath = $thumbDir . $newName;
        createThumbnail($sourcePath, $thumbPath, 300, 300);

        // Zapis do bazy
        $stmt = $pdo->prepare("INSERT INTO images (filename, keywords, category) VALUES (?, ?, ?)");
        $stmt->execute([$newName, $keywords, $category]);

        echo "<p style='color:green;'>Obrazek dodany pomyślnie!</p>";
    } else {
        echo "<p style='color:red;'>Nieprawidłowy format pliku!</p>";
    }
}

function createThumbnail($src, $dest, $thumbWidth, $thumbHeight) {
    $info = getimagesize($src);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg': $img = imagecreatefromjpeg($src); break;
        case 'image/png':  $img = imagecreatefrompng($src);  break;
        default: return false;
    }

    $width = imagesx($img);
    $height = imagesy($img);

    // Вычисляем соотношение сторон
    $srcRatio = $width / $height;
    $thumbRatio = $thumbWidth / $thumbHeight;

    if ($srcRatio > $thumbRatio) {
        // изображение шире — обрезаем по ширине
        $newHeight = $height;
        $newWidth = $height * $thumbRatio;
        $srcX = ($width - $newWidth) / 2;
        $srcY = 0;
    } else {
        // изображение выше — обрезаем по высоте
        $newWidth = $width;
        $newHeight = $width / $thumbRatio;
        $srcX = 0;
        $srcY = ($height - $newHeight) / 2;
    }

    $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumb, $img, 0, 0, $srcX, $srcY, $thumbWidth, $thumbHeight, $newWidth, $newHeight);

    switch ($mime) {
        case 'image/jpeg': imagejpeg($thumb, $dest, 90); break;
        case 'image/png':  imagepng($thumb, $dest);       break;
    }

    imagedestroy($img);
    imagedestroy($thumb);
}

?>

</body>
</html>
