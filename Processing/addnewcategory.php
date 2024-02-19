<?php
require_once '../Processing/connect.php';
$name = $_POST['tendanhmuc'];
$trademark = $_POST['thuonghieu'];
$status = $_POST['trangthai'];
$datecreated = $_POST['ngaytao'];
if (empty(trim($name))) {
    $response = "nulltendanhmuc";
} else if (empty(trim($trademark))) {
    $response = "nullthuonghieu";
} else {
    $checkQuery = "SELECT * FROM category WHERE name = '$name' and trademark = '$trademark'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        $response = "Danh mục đã tồn tại";
    } else {
        $insertQuery = "INSERT INTO category (name, trademark, status, datecreated) 
                        VALUES ('$name', '$trademark', '$status', '$datecreated')";

        if ($conn->query($insertQuery) === TRUE) {
            $response = "true";
        }
    }
}
$conn->close();
echo $response;
?>