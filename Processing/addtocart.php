<?php
session_start();
require_once '../Processing/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();

    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $id = $_POST["id"];
        $quantity = $_POST["quantity"];
 
        if (empty(trim($quantity))) {
            $response['message'] = 'Vui Lòng Nhập Số Lượng';
        } else {
            $sqlQuantity = "SELECT * FROM product WHERE id = ?";
            $stmtQuantity = $conn->prepare($sqlQuantity);
            $stmtQuantity->bind_param("i", $id);
            $stmtQuantity->execute();
            $resultQuantity = $stmtQuantity->get_result();

            if ($resultQuantity && $resultQuantity->num_rows > 0) {
                $row = $resultQuantity->fetch_assoc();
                $availableQuantity = $row['quantity'];
                
                $sqlCartQuantity = "SELECT SUM(quantity) as total_quantity FROM cart WHERE username = ? AND idproduct = ?";
                $stmtCartQuantity = $conn->prepare($sqlCartQuantity);
                $stmtCartQuantity->bind_param("si", $username, $id);
                $stmtCartQuantity->execute();
                $resultCartQuantity = $stmtCartQuantity->get_result();
                $rowCartQuantity = $resultCartQuantity->fetch_assoc();
                $totalCartQuantity = $rowCartQuantity['total_quantity'];

                if (($totalCartQuantity + $quantity) <= $availableQuantity) {

                    $sqlUserAndProduct = "SELECT * FROM cart WHERE username = ? AND idproduct = ?";
                    $stmtUserAndProduct = $conn->prepare($sqlUserAndProduct);
                    $stmtUserAndProduct->bind_param("si", $username, $id);
                    $stmtUserAndProduct->execute();
                    $resultUserAndProduct = $stmtUserAndProduct->get_result();

                    if ($resultUserAndProduct && $resultUserAndProduct->num_rows > 0) {
                        $sql = "UPDATE cart SET quantity = quantity + ? WHERE username = ? AND idproduct = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("isi", $quantity, $username, $id);
                    } else {
                        $sql = "INSERT INTO cart (username, idproduct, quantity) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sii", $username, $id, $quantity);
                    }

                    if ($stmt->execute() && $stmt->affected_rows > 0) {
                        $response['message'] = 'true';
                    } else {
                        $response['message'] = 'Thất Bại';
                    }
                } else {
                    $response['message'] = 'Số Lượng Hàng Không Đủ';
                }
            } else {
                $response['message'] = 'Không Tìm Thấy Sản Phẩm';
            }
        }
    } else {
        $response['message'] = 'Vui Lòng Đăng Nhập';
    }

    echo json_encode($response);
    exit;
}

$conn->close();
?>
