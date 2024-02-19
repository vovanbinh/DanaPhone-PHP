<?php
require_once '../Processing/connect.php';
$selectedValue = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : null;
$searchValue = isset($_POST['searchValue']) ? $_POST['searchValue'] : null;

$sql = "SELECT * FROM users"; 
$where = [];

if ($selectedValue !== null) {
    $where[] = "permission = '$selectedValue'";
}

if ($searchValue !== null) {
    $searchValue = mysqli_real_escape_string($conn, $searchValue);
    $where[] = "(name LIKE '%$searchValue%' OR email LIKE '%$searchValue%')";
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$result = mysqli_query($conn, $sql); 
$response = "";
$stt = 1;
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row["username"];
        $name = $row['name'];
        $email = $row['email'];
        $permission = $row['permission'];
        $image = $row['image'];    
        $datecreated = $row['datecreated'];        
        $response .= '<tr>';
        $response .= '<td class="small">'.$stt.'</td>';
        $response .= '<td class="small">'.$username.'</td>';
        $response .= '<td class="small col-2"> '.$name.'</td>';
        $response .= '<td class="small col-2">'.$email.'</td>';
        if ($permission == 1) {
            $permissionText = "Quản Trị Viên";
            $permissionColor = "green"; 
        } else {
            $permissionText = "Khách Hàng";
            $permissionColor = "blue"; 
        }
        
        $response .= '<td class="small" style="color: ' . $permissionColor . '">' . $permissionText . '</td>';
        $response .= '<td class="small">';
        if (!empty($image)) {
            $response .= '<img src="../Public/images/'.$image.'" alt="Ảnh Người Dùng" style="width: 60px;">';
        } else {
            $response .= '<img src="../Public/images/user3.png" alt="Ảnh Người Dùng" style="width: 60px;">';
        }
        $response .= '</td>';
        $response .= '<td class="small">'.$datecreated.'</td>';
        $response .= '<td class="small">';
        $response .= '<a class="btn btn-success view-btn" href="../Views/Admin_view_account.php?username=' .$username . '">Xem</a>';
        $response .= '<a class="btn btn-warning edit-btn"  href="../Views/Admin_update_account.php?username=' .$username . '">Chỉnh Sửa Quyền</a>';
        $response .= '</td>';
        $response .= '</tr>';
        $stt += 1;
    }
}
$conn->close();
echo $response;
?>
