<?php

session_start();
require_once '../Processing/connect.php';

$infoship = $_POST['id_info_ship'];
$username = $_SESSION['username'];
$createat = $_POST["createat"];
$paymentstatus = $_POST['paymentstatus'];
$paymentmethod = $_POST['paymentmethod'];

$can_approve = true;

if ($paymentmethod == "PayPal") {
    $sql_check_cart = "SELECT cart.idproduct, cart.quantity, product.quantity AS available_quantity, product.price
                      FROM cart
                      INNER JOIN product ON cart.idproduct = product.id
                      WHERE cart.username = '$username'";

    $cart_result = mysqli_query($conn, $sql_check_cart);

    while ($cartRow = mysqli_fetch_assoc($cart_result)) {
        $productId = $cartRow['idproduct'];
        $quantity = $cartRow['quantity'];
        $available_quantity = $cartRow['available_quantity'];
        $price = $cartRow['price'];
        
        if ($quantity > $available_quantity) {
            $can_approve = false;
            break;
        }
    }

    if ($can_approve) {
        // Thêm đơn hàng và chi tiết đơn hàng
        $sql_order = "INSERT INTO oder (username, payment_method, create_at, id_info_ship, payment_status, admin_status) 
                      VALUES ('$username', '$paymentmethod', '$createat', '$infoship', '$paymentstatus', 1)";
        
        if ($conn->query($sql_order) === TRUE) {
            $idorder = mysqli_insert_id($conn);

            mysqli_data_seek($cart_result, 0);
            
            $totalAmount = 0; // Tổng tiền của đơn hàng

            while ($cartRow = mysqli_fetch_assoc($cart_result)) {
                $productId = $cartRow['idproduct'];
                $quantity = $cartRow['quantity'];
                $price = $cartRow['price'];
                $total = $quantity * $price;
                $sql_detail = "INSERT INTO order_detail (oder_id, product_id, product_price, product_quantity)
                               VALUES ('$idorder', '$productId', '$price', '$quantity')";
                $result2 = mysqli_query($conn, $sql_detail);

                // Cập nhật số lượng sản phẩm trong kho
                $update_quantity_sql = "UPDATE product SET quantity = quantity - $quantity WHERE id = $productId";
                mysqli_query($conn, $update_quantity_sql);
                
                $totalAmount += $total; // Cộng tổng tiền
            }

            $sql_delete_cart = "DELETE FROM cart WHERE username = '$username'";
            mysqli_query($conn, $sql_delete_cart);

            echo 200;
        } else {
            echo 'Lỗi khi tạo đơn hàng';
        }
    } else {
        echo 'Không đủ số lượng hàng';
    }
} else {
    // Thanh toán không phải PayPal
    $sql_order = "INSERT INTO oder (username, payment_method, create_at, id_info_ship, payment_status) 
                  VALUES ('$username', '$paymentmethod', '$createat', '$infoship', '$paymentstatus')";
    
    if ($conn->query($sql_order) === TRUE) {
        $idorder = mysqli_insert_id($conn);

        $sqlcheck = "SELECT cart.idproduct, cart.quantity, product.price FROM cart
                    INNER JOIN product ON cart.idproduct = product.id
                    WHERE cart.username = '$username'";
        
        $cartResult = mysqli_query($conn, $sqlcheck);

        if ($cartResult && mysqli_num_rows($cartResult) > 0) {
            while ($cartRow = mysqli_fetch_assoc($cartResult)) {
                $productId = $cartRow['idproduct'];
                $quantity = $cartRow['quantity'];
                $price = $cartRow['price'];
                $total = $quantity * $price;
                $sql_detail = "INSERT INTO order_detail (oder_id, product_id, product_price, product_quantity)
                               VALUES ('$idorder', '$productId', '$price', '$quantity')";
                $result2 = mysqli_query($conn, $sql_detail);
            }
        }

        $sql_delete_cart = "DELETE FROM cart WHERE username = '$username'";
        mysqli_query($conn, $sql_delete_cart);
        
        echo 'Bạn đã thanh toán thành công<br>';
        echo 'Tổng tiền: ' . $total . ' đ';
    } else {
        echo 'Lỗi khi tạo đơn hàng';
    }
}

$conn->close();
?>

