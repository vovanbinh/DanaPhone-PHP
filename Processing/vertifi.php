<?php
require_once '../Processing/connect.php';
session_start();

if (isset($_POST["vertifiCode"])) {
    $username = $_POST["username"];
    $vertifiCode = $_POST["vertifiCode"];

    if (empty(trim($vertifiCode))) {
        $response = array('message' => 'Vui Lòng Nhập Mã Xác Thực');
        echo json_encode($response);
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $verificationCodes = $row['verificationcodes'];

            if ($verificationCodes == $vertifiCode) {
                $sqlUpdate = "UPDATE users SET vertified = 1 WHERE username = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param("s", $username);
                $stmtUpdate->execute();
                if ($stmtUpdate->affected_rows > 0) {
                    $permission = $row['permission'];
                    $response = array('success' => true, 'permission' => $permission);
                    $_SESSION['username'] = $username;
                    echo json_encode($response);
                } else {
                    $response = array('message' => 'Lỗi khi cập nhật trạng thái xác thực');
                    echo json_encode($response);
                }
            } else {
                $response = array('message' => 'Mã xác thực không đúng');
                echo json_encode($response);
            }
        } else {
            $response = array('message' => 'Không tìm thấy người dùng');
            echo json_encode($response);
        }
    }
}
$conn->close();
?>
