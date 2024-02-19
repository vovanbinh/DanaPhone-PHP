<?php
require_once '../Processing/connect.php';
$selectedValue = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : null;
$searchValue = isset($_POST['searchValue']) ? $_POST['searchValue'] : null;
$sql = "SELECT * FROM category"; 
$where = [];
if ($selectedValue !== null) {
    $where[] = "status= '$selectedValue'";
}
if ($searchValue !== null) {
    $searchValue = mysqli_real_escape_string($conn, $searchValue);
    $where[] = "(name LIKE '%$searchValue%' OR trademark LIKE '%$searchValue%')";
}
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$result = mysqli_query($conn, $sql); 
$response = "";
$i=1;
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $name = $row['name'];
        $trademark = $row['trademark'];
        $status = $row['status'];
        $datecreated = $row['datecreated'];
        if ($status == 0) {
            $statusText = "Mở Bán";
            $statusColor = "green"; 
        } else if ($status == 1) {
            $statusText = "Dự Kiến";
            $statusColor = "blue"; 
        } else {
            $statusText = "Unknown";
            $statusColor = "gray"; 
        }
        $response .= '<tr>';
        $response .= '<td>'.$i.'</td>';
        $response .= '<td>'.$name.'</td>';
        $response .= '<td>'.$trademark.'</td>';
        $response .= '<td>'.$datecreated.'</td>';
        $response .= '<td style="color: ' . $statusColor . ';">' . $statusText . '</td>';
        $response .= '<td style="min-width:160px; max-width:160px;">';
        $response .= '<button class="btn btn-danger delete-btn" data-id="'.$id.'"><i class="fas fa-trash"></i></button>';
        $response .= '<a class="btn btn-warning ml-2 edit-btn" href="../Views/admin_update_category.php?id='.$id.'"> <i class="fas fa-edit"></i></a>';
        $response .= '<a class="btn btn-success ml-2 view-btn" href="../Views/Admin_view_category.php?id='.$id.'"> <i class="fas fa-eye"></i></a>';
        $response .= '</td>';
        $response .= '</tr>';
        $i+=1;
    }
}
$conn->close();
echo $response;
?>
