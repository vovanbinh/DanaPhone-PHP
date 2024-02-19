<?php
    require_once '../Processing/connect.php';

    $id = $_POST['id'];

    $sql = "SELECT p.id, p.name, p.price, p.quantity, p.image, p.color,p.describe, p.datecreated, p.status, c.id AS category_id, c.name AS category_name
            FROM product p
            JOIN category c ON p.catalogcode = c.id
            WHERE p.id = '$id'";
    $result = mysqli_query($conn, $sql);

    $response = "";

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $image = $row['image'];
        $color = $row['color'];
        $datecreated = $row['datecreated'];
        $status = $row['status'];
        $category_id = $row['category_id'];
        $category_name = $row['category_name'];
        $describe= $row['describe'];
        $response .= '<div class="form-group">';
        $response .= '<label for="tendanhmuc">Danh Mục</label>';
        $response .= '<select class="form-control" id="tendanhmuc">';
        
        $categoryQuery = "SELECT * FROM category";
        $categoryResult = mysqli_query($conn, $categoryQuery);
        if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
            while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                $catId = $categoryRow['id'];
                $catName = $categoryRow['name'];
                $selected = ($catId == $category_id) ? 'selected' : '';
                $response .= '<option value="' . $catId . '" ' . $selected . '>' . $catName . '</option>';
            }
        }
        $response .= '</select>';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="tensanpham">Tên Sản Phẩm</label>';
        $response .= '<label class="text-warning ml-2" id="ername"> </label>';
        $response .= '<input type="text" class="form-control" id="tensanpham" value="' . $name . '">';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="gia">Giá</label>';
        $response .= '<label class="text-warning ml-2" id="ergia"> </label>';
        $response .= '<input type="text" class="form-control" id="gia" value="' . $price . '">';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="soluong">Số Lượng</label>';
        $response .= '<label class="text-warning ml-2" id="ersoluong"> </label>';
        $response .= '<input type="text" class="form-control" id="soluong" value="' . $quantity . '">';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="anh">Hình Ảnh</label>';
        $response .= '<input type="file" id="anh" class="form-control-file">';
        $response .= '<input type="hidden" id="anhcu" value="'.$image.'">';
        $response .= '<img class="mt-3" width="100px" src="../Public/images/'.$image.'">';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="mota">Mô Tả</label>';
        $response .= '<label class="text-warning ml-2" id="ermota"> </label>';
        $response .= '<textarea id="mota"  class="col-12" rows="5">' . $describe . '</textarea>';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="mau">Màu</label>';
        $response .= '<label class="text-warning ml-2" id="ermau"> </label>';
        $response .= '<input type="text" class="form-control" id="mau" value="' . $color . '">';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="ngaytao">Ngày Tạo</label>';
        $response .= '<input type="text" class="form-control" id="ngaytao" value="' . $datecreated . '" readonly>';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label>Trạng Thái</label>';
        $response .= '<div class="form-check">';
        $response .= '<input class="form-check-input" type="radio" name="trangthai" value="0"';
        if ($status == 0) {
            $response .= ' checked';
        }
        $response .= '>';
        $response .= '<label class="form-check-label ml-2" for="trangthai-moban">Mở Bán</label>';
        $response .= '</div>';
        $response .= '<div class="form-check">';
        $response .= '<input class="form-check-input" type="radio" name="trangthai" value="1"';
        if ($status == 1) {
            $response .= ' checked';
        }
        $response .= '>';
        $response .= '<label class="form-check-label ml-2" for="trangthai-dukien">Dự Kiến</label>';
        $response .= '</div>';
        $response .= '</div>';
        $response .= '<div class="text-center">';
        $response .= '<a class="btn btn-primary text-white mb-3 mr-5" href="../Views/Admin_product.php">Trở Về</a>';
        $response .= '<button type="submit" id="suasanpham" class="btn btn-success mb-3">Lưu Lại</button>';
        $response .= '</div>';
    }
    $conn->close();
    echo $response;
?>
