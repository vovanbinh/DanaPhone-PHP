<?php
require_once '../Processing/connect.php';

$forgot_code = $_POST["forgot_code"];
$password = $_POST["password"];
$rpassword = $_POST["rpassword"];
$response = array();

if (empty(trim($password))) {
    $response['message'] = 'Vui lòng nhập Mật Khẩu';
} else if (empty(trim($rpassword))) {
    $response['message'] = 'Vui lòng nhập Lại Mật Khẩu';
} else if (strlen($password) < 6) {
    $response['message'] = 'Mật khẩu phải có ít nhất 6 kí tự';
} else if ($password != $rpassword) {
    $response['message'] = 'Mật khẩu phải giống nhau';
} else if (strlen($password) > 20) {
    $response['message'] = 'Mật khẩu phải nhỏ hơn 20 ký tự';
} else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "SELECT * FROM users WHERE forgot_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $forgot_code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $sqlupdate = "UPDATE users SET password = ? WHERE forgot_code = ?";
        $stmt = $conn->prepare($sqlupdate);
        $stmt->bind_param("ss", $hashed_password, $forgot_code);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response['message'] = 'true';
        } else {
            $response['message'] = 'Failed to update password';
        }
    }
}
echo json_encode($response);
$conn->close();
?>