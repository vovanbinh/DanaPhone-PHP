<?php
require_once '../Processing/connect.php';

$response = '';

$id = $_POST['id'];
$catalogcode = $_POST['madanhmuc'];
$name = $_POST['tensanpham'];
$price = $_POST['gia'];
$quantity = $_POST['soluong'];
$describe = $_POST['mota'];
$color = $_POST['mau'];
$ngayupdate = $_POST['ngayupdate'];
$status = $_POST['trangthai'];

if(empty(trim($name))){
    $response = "nullname";
}else if(empty(trim($price))){
    $response = "nullgia";
}elseif (!is_numeric($price)) {
    $response = "ergia";
}elseif ($price<=0) {
    $response = "amgia";
}else if(empty(trim($quantity))){
    $response = "nullsoluong";
}elseif (!is_numeric($quantity)) {
    $response = "ersoluong";
}elseif ($quantity<=0) {
    $response = "amsoluong";
}else if(empty(trim($describe))){
    $response = "nullmota";
}else if(strlen($describe) < 10){
    $response = "errormota";
}else if(empty(trim($color))){
    $response = "nullmau";
}else if($status!=0 && $status!=1 ){
    $response = "errorstatus";
}else{
    if (isset($_FILES['anh']) && $_FILES['anh']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES["anh"]["name"];
        $tmpname = $_FILES["anh"]["tmp_name"];
        $newimagename = uniqid() . '_' . $filename;
        $destination = '../Public/images/' . $newimagename;

        if (move_uploaded_file($tmpname, $destination)) {
            $image = $newimagename;
        } else {
            $response = 'Lỗi khi di chuyển ảnh.';
            echo $response;
            exit;
        }
    } else {
        $image = $_POST['anhcu'];
    }

    $insertQuery = "UPDATE product SET name = ?, price = ?, `describe` = ?, quantity = ?, image = ?, color = ?, update_at = ?, catalogcode = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssssssi", $name, $price, $describe, $quantity, $image, $color, $ngayupdate, $catalogcode, $status, $id);

    if ($stmt->execute()) {
        $response = '200';
    } else {
        $response = 'Lỗi khi chèn dữ liệu vào cơ sở dữ liệu: ' . $stmt->error;
    }
}

$conn->close();

echo $response;
?>
