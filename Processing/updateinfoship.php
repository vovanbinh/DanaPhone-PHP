<?php
    session_start();
    $username = $_SESSION['username'];
    require_once '../Processing/connect.php';
    if (isset($_POST['selectedId'])) {
        $id = $_POST['selectedId'];
        $sql = "SELECT * FROM info_ship WHERE id = '".$id."' and username = '".$username."'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $fullname = $row['fullname'];
            $phonenumber = $row['phonenumber'];
            $address = $row['address'];
            echo '<label class="form-check-label" data-id="' . $id . '">' . $fullname . ' - ' . $phonenumber . ' - ' . $address . '</label><br>';
        }
    } else {
        $sql = "SELECT * FROM info_ship WHERE note = 1 and username = '". $username."'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id=$row['id'];
            $fullname = $row['fullname'];
            $phonenumber = $row['phonenumber'];
            $address = $row['address'];
            echo '<label class="form-check-label " data-id="' . $id . '">' . $fullname . ' - ' . $phonenumber . ' - ' . $address . '</label><br>';
        }else{
            echo "Vui lòng chọn địa chỉ nhận hàng";
        }
    }
    
    $conn->close();
?>
