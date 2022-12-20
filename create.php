<?php
require("connect_db.php");
if(isset($_POST['submit'])){
    $query = "INSERT INTO items (title, img) VALUES(?, ?)";
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
        $image = file_get_contents($_FILES['img_upload']['tmp_name']);
        $imgOk = 1;
    } else {
        $errors = $errors . "Отсутствует прикреплённое изображение.<br>";
        $imgOk = 0;
    }
    if ($imgOk) {
        $check = getimagesize($_FILES["img_upload"]["tmp_name"]);
        if ($check !== false) {
            $imgOk = 1;
        } else {
            $errors = $errors . "Файл не является изображением.<br>";
            $imgOk = 0;
        }
    }
    if ($imgOk && $_FILES["img_upload"]["size"] > 134217728) { // Max size 128M
        $errors = $errors . "Изображение слишком большого изображения.<br>";
        $imgOk = 0;
    }


    if ($titleOk && $imgOk){
        $stmt = $db->prepare($query);
        try {
            $stmt->execute([$title, $image]);
            echo '<script>alert("Запись успешно добавлена в базу.")</script>';
            $last_id = $db->lastInsertId();
            echo "<script>
                    alert('Запись успешно добавлена в базу.');
                    document.location.href='index.php?id=$last_id';
                    </script>";
            die();
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
        }


    } else {
        echo "<div class='warning'>$errors</div>";

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body class="container">
<ul class="header container" >
    <a class="header-item header-item_accent" href="list.php">На главную</a>
<!--    <a class="header-item" href="index.php?id=--><?php //= $value["id"] ?><!--">Открыть работу</a>-->
<!--    <a class="header-item" href="delete.php?id=--><?php //= $value["id"] ?><!--">Удалить</a>-->
</ul>
<form action="" method="POST" enctype="multipart/form-data">
    <div style="width: 100%;">Title: <input type="text" name="new_title" placeholder="Заголовок">
    </div>
    <div style="width: 100%;">Select image to upload:<br> <input type="file" name="img_upload" id="img_upload"></div>
    <button class="contacts-button" style="display: block; margin: 0 auto" type="submit" name="submit">Добавить</button>
</form>

</body>
</html>