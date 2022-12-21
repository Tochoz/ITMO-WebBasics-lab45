<?php
require "connect_db.php";
$query = "SELECT * FROM items WHERE id = ?";


if (isset($_GET["id"]) && is_numeric($_GET["id"])){ // проверить без
    $id = $_GET["id"];
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([$id]);
        $value = $stmt->fetch();
        if (!$value) {
            ?>
            <h1> 404 Not found </h1>
            Запрошенного элемента не существует.
            <?php
        } else {
            ?>
            <!doctype html>
            <html lang="ru">
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
                <title>Работа <?= $value["id"] ?></title>
            </head>
            <body>
            <ul class="header container">
                <a class="header-item header-item_accent" href="list.php">На главную</a>
                <a class="header-item" href="update.php?id=<?= $value["id"] ?>">Редактировать</a>
                <form class="clear" method="post" action="delete.php">
                    <input type="hidden" name="id" value="<?= $value["id"] ?>">
                    <button type="submit" class="clear header-item">Удалить</button>
                </form>
            </ul>
            <div class="container">
            <h1 style="text-align: center;"> <?= $value["title"] ?> </h1>
            <img style="display: block; border: 1px solid black; max-width: 100%; min-width: 50%; margin: 1em auto;"  src="data:image/jpeg;base64,<?=base64_encode($value['img'])?>"/>

            </div>
            </body>
            </html>
            <?php
        }
    } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
} else {
?>
    <h1> 404 Not found </h1>
    Запрошенной страницы не существует.
<?php
}
?>