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
        if ($result && mysqli_num_rows($result) > 0) {
            require_once '../Views/Admin_head.php';
            ?>
        </head>

        <body>
            <?php
            require_once '../Views/Admin_left_menu.php';
            ?>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div>Sửa Thông Tin Sản Phẩm<div class="page-title-subheading">Hãy thay đổi các thông tin của sản phẩm mà bạn cần!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 justify-content-center">
                        <div class="main-card col-9 card mb-3 justify-content-center" >
                            <div class="row ml-1 col-12 justify-content-center">
                                <div class="col-12">
                                    <h1 class="text-center mb-4">Sửa Thông Tin Sản Phẩm</h1>
                                    <form id="formupdateproduct" class="showinfo">
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    require_once '../Views/Admin_footer.php';
                    ?>
        </body>
        <script>
             var url = window.location.href;
    var match = url.match(/[?&]id=(\d+)/);
    var id = match ? match[1] : null;

    function view_data() {
        $.post('../processing/showinfoproduct.php', { id: id }, function(data) {
            $(".showinfo").html(data);
        });
    }

    $(document).ready(function() {
        view_data();
        $("#formupdateproduct").submit(function(event) {
            event.preventDefault();
            var selectedCategoryId = $("#tendanhmuc").val();
            var formData = new FormData();
            formData.append('id', id);
            formData.append('madanhmuc', selectedCategoryId);
            formData.append('tensanpham', $('#tensanpham').val());
            formData.append('gia', $('#gia').val());
            formData.append('soluong', $('#soluong').val());
            formData.append('anh', $('#anh')[0].files[0]);
            formData.append('anhcu', $('#anhcu').val());
            formData.append('mota', $('#mota').val());
            formData.append('mau', $('#mau').val());
            formData.append('ngayupdate', new Date().toISOString());
            formData.append('trangthai', $('input[name="trangthai"]:checked').val());
            $.ajax({
                url: '../Processing/updateproduct.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var customresponse="";
                    if (response === "200") {
                        window.location.href = '../views/Admin_product.php';
                    }else if(response=="nullname"){
                        customresponse=" Vui lòng nhập tên sản phẩm";
                    }else if(response=="nullgia"){
                        customresponse=" Vui lòng nhập giá tiền";
                    }else if(response=="amgia"){
                        customresponse=" Vui nhập giá tiền lớn hơn 0";
                    }else if(response=="ergia"){
                        customresponse=" Vui lòng nhập giá là số";
                    }else if(response=="nullsoluong"){
                        customresponse=" Vui lòng nhập số lượng";
                    }else if(response=="ersoluong"){
                        customresponse=" Vui lòng nhập số lượng là số";
                    }else if(response=="amsoluong"){
                        customresponse=" Vui lòng nhập số luongj lớn hơn 0";
                    }else if(response=="nullmota"){
                        customresponse=" Vui lòng nhập mô tả";
                    }else if(response=="errormota"){
                        customresponse=" Mô tả quá ngắn";
                    }else if(response=="nullmau"){
                        customresponse=" Vui lòng nhập màu";
                    }else if(response=="errorstatus"){
                        customresponse="Không được sửa hệ thống";
                    }else  {
                        customresponse =response;
                    }
                    Toastify({
                        text: customresponse,
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
                    Toastify({
                        text: "Có Lỗi Xảy Ra Vui Lòng Thử Lại Sau",
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