<?php
    require_once '../Processing/connect.php';
    $id = $_POST["id"];
    $sql = "DELETE FROM category WHERE id = $id"; 
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
?>