<?php
require_once '../Processing/connect.php';

if (isset($_FILES['anh'])) {
    $image = $_FILES['anh'];
    $catalogcode = $_POST['madanhmuc'];
    $name = $_POST['tensanpham'];
    $price = $_POST['gia'];
    $quantity = $_POST['soluong'];
    $describe = $_POST['mota'];
    $color = $_POST['mau'];
    $datecreated = $_POST['ngaytao'];
    $status = $_POST['trangthai'];
    if(empty(trim($name))){
        $response = "nullname";
    }else if(empty(trim($price))){
        $response = "nullgia";
    }else if(empty(trim($quantity))){
        $response = "nullsoluong";
    }else if(empty(trim($describe))){
        $response = "nullmota";
    }else if(empty(trim($color))){
        $response = "nullmau";
    }else{
        $checkQuery = "SELECT * FROM product WHERE name = '$name' and catalogcode = '$catalogcode'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $response = "Sản Phẩm đã tồn tại";
        } else {
            $filename = $_FILES["anh"]["name"];
            $tmpname = $_FILES["anh"]["tmp_name"];
            $newimagename = uniqid() . '_' . $filename;
            $destination = '../Public/images/' . $newimagename;

            if (move_uploaded_file($tmpname, $destination)) {
                $insertQuery = "INSERT INTO product (name, price, `describe`, quantity, image, color, datecreated, catalogcode, status) 
                VALUES ('$name', '$price', '$describe', '$quantity', '$newimagename', '$color', '$datecreated', '$catalogcode', '$status')";
        
                if ($conn->query($insertQuery) === TRUE) {
                    $response = 200;
                } else {
                    $response = "Lỗi khi chèn dữ liệu vào cơ sở dữ liệu: ";
                }
            } else {
                $response = "Lỗi khi di chuyển ảnh.";
            }
        }             
    }
} else {
    $response = "Vui lòng chọn ảnh.";
}
$conn->close();

echo $response;
?>
