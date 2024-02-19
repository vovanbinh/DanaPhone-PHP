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
                            <div>Thêm Mới Danh Mục Sản Phẩm<div class="page-title-subheading">Thêm các Danh Mục mới của cửa hàng!</div>
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
                                    <input type="text" class="form-control" id="tendanhmuc">
                                </div>
                                <div class="form-group">
                                    <label for="thuonghieu">Thương Hiệu</label>
                                    <input type="text" class="form-control" id="thuonghieu">
                                </div>
                                <div class="form-group">
                                    <label for="ngaytao">Ngày Tạo</label>
                                    <input type="text" class="form-control" id="ngaytao" value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Trạng Thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="trangthai"  value="0" checked>
                                        <label class="form-check-label ml-2" for="mo-ban">
                                            Mở Bán
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="trangthai"  value="1">
                                        <label class="form-check-label ml-2" for="du-kien">
                                            Dự Kiến
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-primary text-white mb-3 mr-5" href="../Views/Admin_category.php">Trở Về</a>
                                    <button type="submit" id="themmoi" class="btn btn-success mb-3">Thêm Mới</button>
                                </div>
                            </form>
                        </div>
                     </div>
                </div>
        <?php
            require_once '../Views/Admin_footer.php';
        ?>
</body>
<script>
$(document).ready(function() {
    $("#formnewcategory").submit(function(event) {
        event.preventDefault();
        var tendanhmuc = $('#tendanhmuc').val();
        var thuonghieu = $('#thuonghieu').val();
        var ngaytao = $('#ngaytao').val();
        var trangthai = $('input[name="trangthai"]:checked').val();

        if (trangthai === undefined) {
            event.preventDefault(); 
            Toastify({
                text: "Vui Lòng Chọn Trạng Thái",
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top", 
                position: "right", 
                stopOnFocus: true, 
                style: {
                    background: "red",
                },
                onClick: function () { } 
            }).showToast();
            return;
        }
        $.ajax({
            url: '../Processing/addnewcategory.php',
            type: 'POST',
            data: {
                tendanhmuc: tendanhmuc,
                thuonghieu: thuonghieu,
                ngaytao: ngaytao,
                trangthai: trangthai
            },
            success: function(response) {
                var customresoponse ="";
                if (response =="true") {
                    window.location.href = '../views/Admin_category.php';
                }else if(response =="nulltendanhmuc"){
                    customresoponse = "Vui lòng nhập tên danh mục!";
                }else if(response =="nullthuonghieu"){
                    customresoponse = "Vui lòng nhập thương hiệu!";
                } else {
                    customresoponse =response;
                }
                event.preventDefault(); 
                Toastify({
                    text: customresoponse,
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", 
                    position: "right", 
                    stopOnFocus: true, 
                    style: {
                        background: "red",
                    },
                    onClick: function () { } 
                }).showToast();
            },
            error: function(xhr, status, error) {
                event.preventDefault(); 
                Toastify({
                    text: "Có Lỗi Xảy Ra, Vui Lòng Thử Lại Sau",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", 
                    position: "right", 
                    stopOnFocus: true, 
                    style: {
                        background: "red",
                    },
                    onClick: function () { } 
                }).showToast();
            }
        });
    });
});
</script>
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
