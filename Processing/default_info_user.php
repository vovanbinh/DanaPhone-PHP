<?php
    session_start();
    $username = $_SESSION['username'];
    require_once '../Processing/connect.php';
    if (isset($_POST['selectedId'])) {
        $id = $_POST['selectedId'];
        $sql = "UPDATE info_ship SET note = CASE WHEN id = $id THEN 1 ELSE 0 END WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_affected_rows($conn) > 0) {
            echo "OK";
        } else {
            echo "Update failed.";
        }
    }
    $conn->close();
?>