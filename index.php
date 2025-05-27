<?php require_once 'includes/db.php'; 

$categories = $pdo->query("SELECT DISTINCT category FROM images")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Galeria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo-title">
            <img src="logo.png" alt="Logo" class="logo">
            <h1>Moja Galeria</h1>
        </div>
        <button id="hamburger">&#9776;</button>
    </div>

    <nav id="menu">
        <a href="index.php">Wszystkie</a>
        <?php
        foreach ($categories as $cat) {
            $c = htmlspecialchars($cat['category']);
            echo "<a href='?category=$c'>$c</a>";
        }
        ?>
    </nav>
</header>



<main>
    <div class="gallery">
        <?php
        $sql = "SELECT * FROM images";
        if (isset($_GET['category'])) {
            $sql .= " WHERE category = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_GET['category']]);
        } else {
            $stmt = $pdo->query($sql);
        }

        foreach ($stmt as $img) {
            $file = htmlspecialchars($img['filename']);
            echo "
    <div class='thumb'>
        <img src='thumbnails/$file' alt='' onclick='showFull(\"images/$file\")'>
        <div class='thumb-info'>
            <p>" . htmlspecialchars($img['category']) . "</p>
        </div>
    </div>
";

        }
        ?>
    </div>
</main>

<!-- Splashscreen -->
<div id="splash" onclick="hideFull()">
    <span id="close">×</span>
    <img id="fullImage" src="">
</div>
<button id="toTop">↑</button>
<script src="js/script.js"></script>
</body>
</html>
