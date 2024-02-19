<?php
    require_once '../Processing/connect.php';

    $selectedValue = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : null;
    $searchValue = isset($_POST['searchValue']) ? $_POST['searchValue'] : null;
    $slidervalue = isset($_POST['slidervalue']) ? $_POST['slidervalue'] : null;
    $categoryvalue = isset($_POST['categoryId']) ? $_POST['categoryId'] : null;
    $where = [];
    if ($selectedValue !== null) {   
        $selectedValue = $_POST["selectedValue"];   
        $where[] = "p.status = '$selectedValue'";
    }
    if ($categoryvalue !== null) {   
        $categoryvalue = $_POST["categoryId"];   
        $where[] = "p.catalogcode = '$categoryvalue'";
    }
    if ($searchValue !== null) {
        $searchValue = $_POST["searchValue"];
        $where[] = "(p.name LIKE '%$searchValue%' OR p.color LIKE '%$searchValue%' OR c.name LIKE '%$searchValue%' )";
    }
    if ($slidervalue !== null) {
        $slidervalue = $_POST["slidervalue"];
        $minPrice = 0;
        $maxPrice = $slidervalue;
        $where[] = "(p.price >= $minPrice AND p.price <= $maxPrice)";
    }
    $whereClause = implode(' AND ', $where); //implode dùng để nối mảng

    $sql = "SELECT p.id, p.name, p.price, p.`describe`, p.quantity, p.image, p.color, p.datecreated, p.update_at, p.catalogcode, p.status, c.name AS category_name
    FROM product p
    JOIN category c ON p.catalogcode = c.id";
    if (!empty($whereClause)) {
    $sql .= " WHERE $whereClause";
    }
    $result = mysqli_query($conn, $sql); 
    $response = "";
    $i=1;
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["id"];
            $name = $row['name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $image = $row['image'];
            $color = $row['color'];
            $datecreated = $row['datecreated'];
            $status = $row['status'];
            $category_name = $row['category_name'];
            $response .= '<tr>';
            $response .= '<td class="small">'.$i.'</td>';
            $response .= '<td class="small">'.$name.'</td>';
            $formattedPrice = number_format($price, 0, '.', '.').' VND';
            $response .= '<td class="small">'.$formattedPrice.'</td>';
            $response .= '<td class="small">'.$quantity.'</td>';
            $response .= '<td class="small">';
            if (!empty($image)) {
                $response .= '<img src="../Public/images/'.$image.'" alt="Ảnh Sản Phẩm" style="width: 100px;">';
            } else {
                $response .= '<span>Không có ảnh</span>';
            }
            $response .= '<td class="small">'.$color.'</td>';
            $response .= '<td class="small">'.$datecreated.'</td>';
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
            $response .= '<td class="small" style="color: ' . $statusColor . ';">' . $statusText . '</td>';
            $response .= '<td class="small">'.$category_name.'</td>';
            $response .= '<td>';
            $response .= '<div class="btn-group" role="group">';
            $response .= '<button class="btn btn-danger delete-btn" data-id="'.$id.'">Xoá</button>';
            $response .= '<a class="btn btn-warning edit-btn" href="../Views/Admin_update_product.php?id=' . $id . '">Sửa</a>';
            $response .= '<a class="btn btn-success edit-btn" href="../Views/Admin_view_product.php?id=' . $id . '">Xem</a>';
            $response .= '</div>';
            $response .= '</td>';            
            $response .= '</tr>';
            $i+=1;
        }
    }
    $conn->close();

    echo $response;
?>
