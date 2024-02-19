<!doctype html>
<html lang="en">
<head>
   <?php
   session_start();
   require_once '../Processing/connect.php';
   if (isset($_SESSION['username'])) {
     $username = $_SESSION['username'];
     $sql = "SELECT * FROM users WHERE username= '$username' AND permission = '1'";
     $result = mysqli_query($conn, $sql);
     if ($result && mysqli_num_rows($result) >0) {
    require_once '../Views/Admin_head.php';
    if (isset($_GET['id'])) {
     $idcategory = $_GET['id'];
    }
    $sql = "SELECT * FROM category WHERE id = '$idcategory' ";
    $result = mysqli_query($conn, $sql);
    $response = "";
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $trademark = $row['trademark'];
        $status = $row['status'];
        $datecreated = $row['datecreated'];
    } else {
       echo "Danh Mục Không Tồn Tại";
    }
?>
</head>
<body>
        <?php
            require_once '../Views/Admin_left_menu.php';
        ?>
        </div>
        <div class="app-main__outer">
            <div class="app-main__inner ">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                            <i class="fas fa-folder-plus"></i>
                            </div>
                            <div>Thông Tin Danh Mục
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">      
                    <div class="row mt-3 justify-content-center mb-3">
                        <div class="col-8  rounded border" style="background-color:white;">
                            <h3 class="text-center mt-1 mb-4 text-black">Thông Tin Danh Mục</h3>
                            <form id="formnewcategory">
                                <div class="form-group">
                                    <label for="tendanhmuc">Tên Danh Mục</label>
                                    <input type="text" class="form-control" id="tendanhmuc" value="<?php echo $name; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="thuonghieu">Thương Hiệu</label>
                                    <input type="text" class="form-control" id="thuonghieu" value="<?php echo $trademark; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="ngaytao">Ngày Tạo</label>
                                    <input type="text" class="form-control" id="ngaytao" value="<?php echo $datecreated; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Trạng Thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="trangthai" value="0" <?php  if ($status == 0) {echo "checked readonly";}?>  readonly>
                                        <label class="form-check-label ml-2" for="mo-ban">
                                            Mở Bán
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="trangthai" value="1"  <?php  if ($status == 1) {echo "checked readonly";}?>  readonly>
                                        <label class="form-check-label ml-2" for="du-kien">
                                            Dự Kiến
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-primary text-white mb-3" href="../Views/Admin_category.php">Trở Về</a>
                                </div>
                            </div>
                            </form>
                        </div>
                     </div>
                </div>
        <?php
            require_once '../Views/Admin_footer.php';
        ?>
</body>
</html>
<?php
    } else {
        header('Location: ../Views/index.php');
        exit();
    }
} else {
    header('Location: ../Views/Login_And_Register.php');
    exit();
}
?>
