<?php 
session_start();
if(isset($_SESSION['username'])) { 
    require_once '../Processing/connect.php';
    $username = $_SESSION['username'];
    $sql = "SELECT COUNT(*) AS cartItemCount FROM cart WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $cartItemCount = 0;
    if ($result) {
    $row = mysqli_fetch_assoc($result);
    $cartItemCount = $row['cartItemCount'];
    }
}
echo $cartItemCount ;
?>