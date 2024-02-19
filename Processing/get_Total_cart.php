<?php
    require_once '../Processing/connect.php';
    session_start();  
    $username = $_SESSION["username"];              
    $sql = "SELECT SUM(cart.quantity * product.price) AS total FROM cart JOIN product ON cart.idproduct = product.id WHERE username='".$username."'";                
    $result = mysqli_query($conn, $sql);                
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];
        $formattedPrice = number_format($total, 0, '.', '.').' VND';
        echo $formattedPrice;
    } else {
        echo "0";
    }
?> 