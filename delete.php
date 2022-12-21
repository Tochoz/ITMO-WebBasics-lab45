<?php
require ("connect_db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id"]) && is_numeric($_POST["id"])){
    $query = "DELETE FROM items WHERE id=?";
    $id = $_POST["id"];
    try {
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="style.css">
            <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
            <link rel="manifest" href="img/favicon/site.webmanifest">
            <title>Deleted</title>
        </head>

        <body class="container">
        <ul class="header container" >
            <a class="header-item header-item_accent" href="list.php">На главную</a>
        </ul>
        <h1>Запись успешно удалена</h1>
        </body>
        </html>
<?php
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} else {
    header("HTTP/1.0 404 Not Found");
}

?>