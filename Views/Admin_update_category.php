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
            <div class="app-main__inner">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div class="page-title-icon">
                            <i class="fas fa-upload"></i>
                            </div>
                            <div>Chỉnh Sửa Danh Mục Sản Phẩm<div class="page-title-subheading">Hãy thay đổi thông tin Danh Mục mà bạn cần!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="mb-3 "style="max-width:552px; min-width: 550px; background-color:white;">      
                        <form id="formupdatecategory" class="showinfo">
                        
                        </form>
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

    function view_data(){     
        $.post('../processing/showinforcategory.php', { id: id }, function(data) {
            $(".showinfo").html(data);
        });
    }
    $(document).ready(function() {
        view_data();
        $("#formupdatecategory").submit(function(event) {
            event.preventDefault();
            var tendanhmuc = $('#tendanhmuc').val();
            var thuonghieu = $('#thuonghieu').val();
            var ngaytao = $('#ngaytao').val();
            var trangthai = $('input[name="trangthai"]:checked').val();
            $.ajax({
                url: '../Processing/updatecategory.php',
                type: 'POST',
                data: {
                    tendanhmuc: tendanhmuc,
                    thuonghieu: thuonghieu,
                    ngaytao: ngaytao,
                    trangthai: trangthai,
                    id: id
                },
                success: function(response ) {
                    var customresponse = "";
                    if (response === "true") {
                        window.location.href = '../views/Admin_category.php';
                    }else if(response=="nullname"){
                        customresponse=" Vui lòng nhập Tên Danh Mục"
                    }else if(response=="nullthuonghieu"){
                        customresponse="Vui lòng nhập thương hiệu";
                    }else if(response=="errorstatus"){
                        customresponse="Không được thay đổi hệ thống!";
                    }else {
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
