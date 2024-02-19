<?php
    session_start();
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
    }
    $stt = 0; 
    require_once '../Processing/connect.php';

    $sql = "SELECT oder.id, oder.create_at, oder.order_status, info_ship.fullname, SUM(order_detail.product_price * order_detail.product_quantity) as total, oder.payment_status, oder.admin_status 
        FROM oder
        JOIN info_ship ON oder.id_info_ship = info_ship.id
        JOIN order_detail ON oder.id = order_detail.oder_id
        WHERE oder.username = '".$username."'
        GROUP BY oder.create_at, info_ship.fullname, oder.payment_status, oder.order_status";
    $result = mysqli_query($conn, $sql); 
    $response = "";
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $stt++;
            $create_at = $row["create_at"];
            $name = $row['fullname'];
            $totalprice = $row['total'];
            $payment_status = $row['payment_status'];
            $admin_status = $row['admin_status']; 
            $order_status = $row['order_status']; 
            $id = $row['id'];
            $response .= '<tr>';
            $response .= '<td>'.$stt.'</td>';
            $response .= '<td>'.$create_at.'</td>';
            $response .= '<td>'.$name.'</td>';
            $formattedPrice = number_format($totalprice, 0, '.', '.').' VND';
            $response .= '<td>'.$formattedPrice.'</td>';
            $response .= '<td>';
            if ($payment_status == 1) {
                $response .= 'Đã thanh toán';
            } else if ($payment_status == 0) {
                $response .= 'Chưa thanh toán';
            } 
            $response .= '</td>';
            $response .= '<td>';
            if ($admin_status == 0) {
                $statusText = 'Chưa Phê Duyệt';
                $statusColor = 'orange';
            } else if ($admin_status == 1 && $order_status != 1) {
                $statusText = 'Đã Phê Duyệt';
                $statusColor = 'green';
            } else if ($admin_status == 2) {
                $statusText = 'Đã Bị Hủy';
                $statusColor = 'red';
            } else if ($order_status == 1 && $admin_status == 1) {
                $statusText = 'Đã Nhận Hàng';
                $statusColor = 'blue';
            }
            $response .= '<span style="color: ' . $statusColor . ';">' . $statusText . '</span></td>';
            $response .= '<td class="small" style="min-width:180px;">';
            $response .= '<a href="../Views/Userorderdetail.php?id='.$id.'" class="btn mr-1" style=" border:none; font-weight: 50;  background-color: #34A853; color: white; padding:5px">Chi Tiết</a>';
            if ($admin_status == 0) {
                $response .= '<a class="btn cancel-btn" data-id="'.$id.'" style="background-color: #DC3545; border:none; font-weight: 50;  color: white; padding:5px;">Hủy Đơn</a>';
            }
            $response .= '</td>';            
            $response .= '</td>';
            $response .= '</tr>';
        }
    }
    $conn->close();
    echo $response;  
?>
