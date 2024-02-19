<?php
require_once '../Processing/connect.php';
$id = $_POST['id'];
$name = $_POST['tendanhmuc'];
$trademark = $_POST['thuonghieu'];
$status = $_POST['trangthai'];
$datecreated = $_POST['ngaytao'];
$response = "";
if(empty(trim($name))){
    $response = "nullname";
}else if(empty(trim($trademark))){
    $response = "nullthuonghieu";
}else if($status!=0 && $status!=1 ){
    $response = "errorstatus";
}else{
    $updateQuery = "UPDATE category SET name = '$name', trademark = '$trademark', status = '$status', datecreated = '$datecreated' WHERE id = '$id'";
    if ($conn->query($updateQuery) === TRUE) {
        $response = "true";
    } else {
        $response = "Lỗi: ";
    }
}
$conn->close();
echo $response;
?>
