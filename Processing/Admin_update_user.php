
<?php
require_once '../Processing/connect.php';
$username = $_POST["username"];
$permission = $_POST["permission"];
if($permission!=0 && $permission!=1 ){
    $permission = "Vui Lòng Chọn Đúng Quyền";
}
$sql = "UPDATE users SET permission = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $permission, $username);
if ($stmt->execute()) {
    $response = 200;
} else {
    $response = "Lỗi";
}
$stmt->close();
$conn->close();
echo $response;

?>
