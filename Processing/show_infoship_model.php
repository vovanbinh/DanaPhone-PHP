<?php 
    session_start();
    require_once '../Processing/connect.php';
    if(isset($_SESSION["username"])){ 
        $username = $_SESSION["username"];
    }
    $sql = "SELECT * FROM info_ship WHERE username = '".$username."'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $fullname = $row['fullname'];
            $phonenumber = $row['phonenumber'];
            $address = $row['address'];
            $default = $row['note'];
            if( $default ==1){
                echo '<input checked  class="mt-2 form-check-input" type="radio" name="address" id="address" value="' . $fullname . ' - '. $phonenumber . ' - ' . $address . '" data-id="' . $id . '">';
                echo '<label class="form-check-label text-success" for="address">'."Mặc Định: " . $fullname . ' - ' . $phonenumber . ' -<b> ' . $address . '</b></label><br>';
            }else{
                echo '<input class="mt-2 form-check-input" type="radio" name="address" id="address" value="' . $fullname . ' - '. $phonenumber . ' - ' . $address . '" data-id="' . $id . '">';
                echo '<label class="form-check-label" for="address">' . $fullname . ' - ' . $phonenumber . ' -<b> ' . $address . '</b></label><br>';
            }
           
        }
    }
    $conn->close();
?>