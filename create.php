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
            header("Location: index.php?id=$last_id");
            die();
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<br>";
        }


    } else {
        echo "<div class='warning'>$errors</div>";

    }

}
//    $title = $_POST['new_title'];
//    $target_dir = "img/media/";
//    $target_name = basename($_FILES["fileToUpload"]["name"]);
//    $uploadOk = 0;
//    $imageFileType = strtolower(pathinfo($target_name,PATHINFO_EXTENSION));
//    // Check if image file is a actual image or fake image
//    if(isset($_POST["submit"])) {
//        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//        if($check !== false) {
//            echo "File is an image - " . $check["mime"] . ".";
//            $uploadOk = 1;
//        } else {
//            echo "File is not an image.";
//            $uploadOk = 0;
//        }
//    }
//    // Check if file already exists
//    if (file_exists($target_name)) {
//        echo "Sorry, file already exists.";
//        $uploadOk = 0;
//    }
//
//    // Check file size
//    if ($_FILES["fileToUpload"]["size"] > 500000000) {
//        echo "Sorry, your file is too large.";
//        $uploadOk = 0;
//    }
//
//    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "svg" ) {
//        echo "Sorry, only JPG, JPEG, PNG & SVG files are allowed.";
//        $uploadOk = 0;
//    }
//    // Check if $uploadOk is set to 0 by an error
//    if ($uploadOk == 0) {
//        echo "Sorry, your file was not uploaded.";
//    // if everything is ok, try to upload file
//    } else {
//        $title = trim($title);
//        $title = stripslashes($title);
//        $title = htmlspecialchars($title);
//        if (!$title){
//            echo "Заголовок не может быть пустым. Портфолио не добавлено.";
//        }
//        else {
//            $newId = mysqli_insert_id($conn);
//            $target_name = $target_dir . $newId . '.' . $imageFileType;
//            $sql = "INSERT INTO portfolio (Title, Url) VALUES ('" . $title . "', '" . $target_name . "')";
//
//            if (mysqli_query($conn, $sql)) {
//                echo "New record created successfully";
//                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_name)) {
//                    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded with " . $target_name . "name";
//                } else {
//                    echo "Sorry, there was an error uploading your file.";
//                }
//            } else {
//                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//            }
//        }
//    }
//mysqli_close($conn);
//}
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
<body>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="new_title" placeholder="Заголовок">
    <br>
    Select image to upload:
    <input type="file" name="img_upload" id="img_upload">
    <br>
    <button type="submit" name="submit">Добавить</button>
</form>

<a href="list.php">Назад</a>
</body>
</html>