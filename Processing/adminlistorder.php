<?php
require_once '../Processing/connect.php';


$selectedValue = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : null;
$searchValue = isset($_POST['searchValue']) ? $_POST['searchValue'] : null;

$sql = "SELECT * FROM oder";
$where = [];
 
if ($selectedValue !== null) {
    if($selectedValue=="ad0"){
        $where[] = "admin_status = '0'";
    }else if($selectedValue=="ad1"){
        $where[] = "admin_status = '1' AND order_status = '0'";
    }else if($selectedValue=="ad2"){
        $where[] = "admin_status = '2'";
    }else if($selectedValue=="od1"){
        $where[] = "order_status = '1'";
    }
}

if ($searchValue !== null) {
    $searchValue = $_POST["searchValue"];
    $where[] = "(username LIKE '%$searchValue%' OR payment_method LIKE '%$searchValue%' OR create_at LIKE '%$searchValue%')";
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}


$result = mysqli_query($conn, $sql);
$response = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $username = $row['username'];
        $payment_method = $row['payment_method'];
        $create_at = $row['create_at'];
        $admin_status = $row['admin_status'];
        $order_status = $row['order_status'];
        $statusText = "";
        if ($order_status == 1) {
            $statusText = "Giao Hàng Thành Công";
            $statusColor = "green"; 
        } else if ($admin_status == 1) {
            $statusText = "Đã phê duyệt";
            $statusColor = "blue"; 
        } else if ($admin_status == 2) {
            $statusText = "Đã Bị Hủy";
            $statusColor = "red"; 
        } else if ($admin_status == 0) {
            $statusText = "Chưa Phê Duyệt";
            $statusColor = "orange"; 
        }
        $response .= '<tr>';
        $response .= '<td class="small">' . $id . '</td>';
        $response .= '<td class="small">' . $username . '</td>';
        $response .= '<td class="small">' . $payment_method . '</td>';
        $response .= '<td class="small">' . $create_at . '</td>';
        $response .= '<td class="small" style="color: ' . $statusColor . ';">' . $statusText . '</td>'; // Áp dụng màu sắc tại đây
        $response .= '<td style="min-width:50px; max-width:50px;" class="small">';
        $response .= '<a class="btn btn-success ml-3 edit-btn" href="../Views/admin_show_detail_oder.php?id=' . $id . '">Xem Chi Tiết</a>';
        $response .= '</td>';
        $response .= '</tr>';
    }
} else {
  
}

$conn->close();
echo $response;
?>
