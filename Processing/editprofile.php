<?php
session_start();
require_once '../Processing/connect.php';
$username = $_SESSION['username'];
$response = "";
if (isset($_POST['oldPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newpassword = $_POST['newPassword'];
    $confirmpassword = $_POST['confirmPassword'];
    if (empty(trim($oldPassword))) {
        $response = "nulloldpassword";
    } else if (empty(trim($newpassword))) {
        $response = "nullnewpassword";
    } else if (empty(trim($confirmpassword))) {
        $response = "nullconfirmpassword";
    } else if ($newpassword !== $confirmpassword) {
        $response = "passwordmismatch";
    } else if (strlen($newpassword) < 8) {
        $response = "passwordtooshort";
    } else if (strlen($newpassword) > 20) {
        $response = "passwordtoolegth";
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            if (password_verify($oldPassword, $hashedPassword)) {
                $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $update = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";
                $result = mysqli_query($conn, $update);
                if ($result) {
                    $response = "infotrue";
                }
            } else {
                $response = "saimatkhaucu";
            }
        }
    }
}
if (isset($_FILES['imageFile'])) {
    $imageName = $_FILES['imageFile']['name'];
    $imageTmpName = $_FILES['imageFile']['tmp_name'];
    $newimagename = uniqid() . '_' . $imageName;
    $destination = '../Public/images/' . $newimagename;
    if (move_uploaded_file($imageTmpName, $destination)) {
        $update = "UPDATE users SET image = '$newimagename' WHERE username = '$username'";
        $result = mysqli_query($conn, $update);
        if ($result) {
            $response = "imagetrue";
        } else {
            $response = "Failed to update image path in the database.";
        }
    } else {
        $response = "Failed to move the uploaded image to the destination folder.";
    }
}

if (isset($_POST['nameValue']) && isset($_POST['phoneValue'])) {
    $name = $_POST['nameValue'];
    $phone = $_POST['phoneValue'];
    if (empty($name)) {
        $response = "ername";
    } else if (empty($phone)) {
        $response = "nullphonenumber";
    } else if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $response = "erphonenumber";
    } else {
        $checkQuery = "SELECT * FROM users WHERE phone = '$phone' AND username != '$username'";
        $checkResult = mysqli_query($conn, $checkQuery);
        if (mysqli_num_rows($checkResult) > 0) {
            $response = "duplicatephone";
        } else {
            $update = "UPDATE users SET name = '$name', phone = '$phone' WHERE username = '$username'";
            $result = mysqli_query($conn, $update);
            if ($result) {
                $response = "infotrue";
            } else {
                $response = "Có lỗi xảy ra. Vui lòng thử lại sau.";
            }
        }
    }
}
$conn->close();
echo $response;
?>