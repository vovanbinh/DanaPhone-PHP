<?php
    require_once '../Processing/connect.php';
    $id = $_POST["id"];
    $idproduct = $_POST["idproduct"];
    $quantity = $_POST["quantity"];

    // Kiểm tra số lượng trong bảng product
    $sqlCheckQuantity = "SELECT quantity FROM product WHERE id = $idproduct";
    $result = mysqli_query($conn, $sqlCheckQuantity);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $availableQuantity = $row['quantity'];

        if ($quantity <= $availableQuantity) {
            $sqlUpdateCart = "UPDATE cart SET quantity = $quantity WHERE id = $id";
            $updateResult = mysqli_query($conn, $sqlUpdateCart);
            if ($updateResult) {
                echo "true";
            } else {
                echo "Đã xảy ra lỗi khi cập nhật số lượng trong giỏ hàng.";
            }
        } else {
            echo "Hàng trong kho chỉ còn " . $row['quantity'] . ".";
        }
    } else {
        echo "Không tìm thấy thông tin sản phẩm.";
    }
?>