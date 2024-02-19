<?php 
    session_start();
    require_once '../Processing/connect.php';
    if(isset($_SESSION["username"])){ 
        $username = $_SESSION["username"];
    }
    $fullname = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $response = "";
    if(empty(trim($fullname))){
        $response = "nullname";
    }else if (strlen($fullname) >50) { // Minimum length for name
        $response = "lengthname";
    }else if (strlen($fullname) <3) { // Minimum length for name
        $response = "shortname";
    }else if (empty(trim($phone))) {
        $response = "nullphonenumber";
    } else if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $response = "erphonenumber";
    } else if (empty(trim($address))) { 
        $response = "eraddress";
    }else if (strlen($address) >100) { 
        $response = "lengthaddress";
    }else if (strlen($address) <10) { 
        $response = "shortaddress";
    }
    else {
        $sql = "INSERT INTO info_ship (username, fullname, phonenumber, address) VALUES ('$username', '$fullname', '$phone', '$address')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $response = "infotrue";
        } else {
            $response = "Có lỗi xảy ra. Vui lòng thử lại sau.";
        }
    }
    echo $response;
    $conn->close();
?>