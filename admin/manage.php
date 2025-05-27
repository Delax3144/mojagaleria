<?php require_once '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zarządzanie galerią</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: center; }
        img { max-width: 100px; }
        a.button { padding: 6px 12px; background: #333; color: white; text-decoration: none; margin: 0 4px; display: inline-block; }
    </style>
</head>
<body>

<h2>Lista obrazów</h2>

<table>
    <tr>
        <th>Miniatura</th>
        <th>Plik</th>
        <th>Kategorie</th>
        <th>Słowa kluczowe</th>
        <th>Akcje</th>
    </tr>

    <?php
    $images = $pdo->query("SELECT * FROM images ORDER BY uploaded_at DESC")->fetchAll();
    foreach ($images as $img) {
        $id = $img['id'];
        $file = htmlspecialchars($img['filename']);
        $keywords = htmlspecialchars($img['keywords']);
        $cat = htmlspecialchars($img['category']);
        echo "
        <tr>
            <td><img src='../thumbnails/$file'></td>
            <td>$file</td>
            <td>$cat</td>
            <td>$keywords</td>
            <td>
                <a class='button' href='edit.php?id=$id'>Edytuj</a>
                <a class='button' href='delete.php?id=$id' onclick='return confirm(\"Na pewno usunąć?\")'>Usuń</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
