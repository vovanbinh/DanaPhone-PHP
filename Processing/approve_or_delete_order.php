<?php
require_once '../Processing/connect.php';
$id = $_POST["id"];
$action = $_POST["action"]; 
$response = "";

if ($action == "delete") {
    $sql = "UPDATE oder SET admin_status = 2 WHERE id = $id"; 
    if ($conn->query($sql) === TRUE) { 
        $response = "Hủy Đơn Hàng Thành Công";
    } else {
        $response = "Lỗi";
    }
} else if ($action == "approve") {
    $order_query = "SELECT od.product_id, od.product_quantity, p.quantity AS available_quantity
                    FROM order_detail od
                    INNER JOIN product p ON od.product_id = p.id
                    WHERE od.oder_id = $id";
    $order_result = $conn->query($order_query);

    $can_approve = true;
    $products_to_update = array(); 

    if ($order_result && $order_result->num_rows > 0) {
        while ($row = $order_result->fetch_assoc()) {
            $product_id = $row["product_id"];
            $order_quantity = $row["product_quantity"];
            $available_quantity = $row["available_quantity"];
            if ($order_quantity > $available_quantity) {
                $can_approve = false;
                break;
            } else {
                $products_to_update[$product_id] = $order_quantity;
            }
        }
    } else {
        $can_approve = false;
    }
    if ($can_approve) {
        $sql = "UPDATE oder SET admin_status = 1 WHERE id = $id"; 
        if ($conn->query($sql) === TRUE) { 
            foreach ($products_to_update as $product_id => $order_quantity) {
                $update_quantity_sql = "UPDATE product SET quantity = quantity - $order_quantity WHERE id = $product_id";
                $conn->query($update_quantity_sql);
            }
            $response = "Phê Duyệt Đơn Hàng Thành Công"; 
        } else { 
            $response = "Lỗi";
        }
    } else {
        $response = "Không đủ số lượng hàng trong kho để phê duyệt đơn hàng này";
    }
} else if ($action == "thanhtoan") {
    $sql = "UPDATE oder SET order_status = 1, payment_status = 1 WHERE id = $id"; 
    if ($conn->query($sql) === TRUE) { 
        $response = 201; 
    } else {
        $response = "Lỗi";
    }
}
$conn->close();
echo $response;
?>
