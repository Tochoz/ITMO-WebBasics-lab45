<?php
require ("connect_db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id"]) && is_numeric($_POST["id"])){
    $query = "DELETE FROM items WHERE id=?";
    $id = $_POST["id"];
    try {
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        echo "Record deleted successfully";
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
} else {
    header("HTTP/1.0 404 Not Found");
}

?>