<?php
    require_once '../Processing/connect.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM category WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql);
    $response = "";
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $trademark = $row['trademark'];
        $status = $row['status'];
        $datecreated = $row['datecreated'];
        $response .= '<div class="form-group">';
        $response .= '<label class="mt-3" for="tendanhmuc">Tên Danh Mục</label>';
        $response  .='<label class="text-warning ml-3" id="ertendanhmuc"> </label>';
        $response .= '<input type="text" class="form-control" id="tendanhmuc" value="' . $name . '">';
        $response .= '</div>';
        $response .= '<div class="form-group">';
        $response .= '<label for="thuonghieu">Thương Hiệu</label>';
        $response  .= '<label class="text-warning ml-3" id="erthuonghieu"> </label>';
        $response .= '<input type="text" class="form-control" id="thuonghieu" value="' . $trademark . '">';
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
        $response .= '<label class="form-check-label ml-2" for="mo-ban">Mở Bán</label>';
        $response .= '</div>';
        $response .= '<div class="form-check">';
        $response .= '<input class="form-check-input" type="radio" name="trangthai" value="1"';
        if ($status == 1) {
            $response .= ' checked';
        }
        $response .= '>';
        $response .= '<label class="form-check-label ml-2" for="du-kien">Dự Kiến</label>';
        $response .= '</div>';
        $response .= '</div>';
        $response .= '<div class="text-center">';
        $response .= '<a class="btn btn-primary text-white mb-3 mr-5" href="../Views/Admin_category.php">Trở Về</a>';
        $response .= '<button type="submit" id="suadanhmuc" class="btn btn-success mb-3">Lưu Lại</button>';
        $response .= '</div>';
    }
    $conn->close();
    echo $response;
?>