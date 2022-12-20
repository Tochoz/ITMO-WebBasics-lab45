<?php
require "connect_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $queryGet = "SELECT * FROM items WHERE id = ?";
    if (isset($_GET["id"]) && is_numeric($_GET["id"])){ // проверить без
        $id = $_GET["id"];
        $stmt = $db->prepare($queryGet);
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
                    <title>Работа <?= $value["id"] ?></title>
                </head>
                <body>
                <ul class="header container">
                    <a class="header-item header-item_accent" href="list.php">На главную</a>
                    <a class="header-item" href="index.php?id=<?= $value["id"] ?>">Открыть работу</a>
                    <form class="clear" method="post" action="delete.php">
                        <input type="hidden" name="id" value="<?= $value["id"] ?>">
                        <button type="submit" class="clear header-item">Удалить</button>
                    </form>
                </ul>
                <div class="container">
                    <form action="?id=<?= $value["id"]?>" method="POST" enctype="multipart/form-data">
                        <div style="width: 100%;">Title: <input type="text" name="new_title" value="<?= $value["title"]?>" placeholder="Заголовок">
                        </div>
                        <div style="width: 100%;">Select image to upload:<br> <input type="file" name="img_upload" id="img_upload"></div>
                        <button class="contacts-button" style="display: block; margin: 0 auto" type="submit" name="submit">Редактировать</button>
                    </form>
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
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queryPost1 = "UPDATE items SET title = ?, img=? WHERE id=?";
    $queryPost2 = "UPDATE items SET title = ? WHERE id=?";
    if(isset($_POST['submit'])){
        $id = $_GET["id"];
        $imgUploaded = 0;
        $imgOk = 0;
        $titleOk = 0;
        $errors = "Запись не была добавлена в базу.<br>Ошибки:<br>";

        $title = $_POST['new_title'];
        if ($title) {
            $titleOk = 1;
        } else{
            $errors = $errors . "Заголовок не может быть пустым.<br>";
            $titleOk = 0;
        }

        if (is_uploaded_file($_FILES['img_upload']['tmp_name'])) {
            $imgUploaded = 1;
            $image = file_get_contents($_FILES['img_upload']['tmp_name']);
            $imgOk = 1;
        }
        if ($imgUploaded && $imgOk) {
            $check = getimagesize($_FILES["img_upload"]["tmp_name"]);
            if ($check !== false) {
                $imgOk = 1;
            } else {
                $errors = $errors . "Файл не является изображением.<br>";
                $imgOk = 0;
            }
        }
        if ($imgUploaded && $imgOk && $_FILES["img_upload"]["size"] > 134217728) { // Max size 128M
            $errors = $errors . "Изображение слишком большого изображения.<br>";
            $imgOk = 0;
        }


        if ($titleOk && (!$imgUploaded || $imgOk)){
            try {
                if ($imgUploaded){
                    $stmt = $db->prepare($queryPost1);
                    $stmt->execute([$title, $image, $id]);
                } else {
                    $stmt = $db->prepare($queryPost2);
                    $stmt->execute([$title, $id]);
                }
                echo "<script>
                    alert('Запись успешно изменена.');
                    document.location.href='index.php?id=$id';
                    </script>";
                die();
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage() . "<br>";
            }


        } else {
            ?>
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <link rel="stylesheet" href="style.css">
                <title>Document</title>
            </head>
            <body class="container">
                <div class='warning'><?= $errors ?></div>
            </body>
            </html>
<?php

        }

    }
}
?>