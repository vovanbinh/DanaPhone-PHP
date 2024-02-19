<!doctype html>
<html lang="en">
    <style>
    .app-container {
        z-index: 9999;
    }
    </style>
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
                            <i class="fas fa-list"></i>
                            </div>
                            <div>Danh Sách Tài Khoản
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="main-card mb-3 col-12 card " style="min-width:495px;"> 
                    <div class="row mt-3 mb-3">
                        <form class="form-inline mt-3" onsubmit="return false;">
                            <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1"  data-id="1" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="btnradio1">Quản Trị Viên</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2"  data-id="0"autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio2">Khách Hàng</label>
                            </div>
                            <div class="input-group">
                            <input class="form-control mr-3 border-end-0 border rounded-pill" type="search"
                                id="search-input" placeholder="Search ...">
                            <span class="input-group-append">
                                <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5"
                                    type="submit" id="search-btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12 ">         
                            <table class="mt-3 table">
                                <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tài Khoản</th>
                                    <th scope="col">Họ Tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phân Quyền</th>
                                    <th scope="col">Ảnh Đại Diện</th>
                                    <th scope="col">Ngày Tạo</th>
                                    <th scope="col">Thao Tác</th>
                                </tr>
                                </thead>
                                <tbody id="listuser">
                                        
                                </tbody>
                            </table>
                            </div> 
                        </div>
 

                    </div>
                </div>
            </div>
        <?php
            require_once '../Views/Admin_footer.php';
        ?>
</body>
<script>

 function view_data(selectedValue, searchValue) {
    $.post('../processing/adminlistuser.php', { selectedValue: selectedValue, searchValue: searchValue }, function(data) {
        $("#listuser").html(data);
    });
}
$(document).ready(function() {
    view_data(); // Initial load with no selected value and search value

    $("input[name='btnradio']").on("change", function() {
        var selectedValue = $(this).data("id");
        var searchValue = $("#search-input").val();
        view_data(selectedValue, searchValue); 
    });

    $("#search-btn").click(function(event) {
        var searchValue = $("#search-input").val();
        if (searchValue.trim() === "") {
            event.preventDefault(); // Ngăn chặn thực hiện tải trang
            Toastify({
                text: "Vui lòng nhập thông tin tìm kiếm",
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top", 
                position: "right", 
                stopOnFocus: true, 
                style: {
                    background: "red",
                },
                onClick: function () { } // Callback after click
            }).showToast();
        } else {
            event.preventDefault();
            var selectedValue = $("input[name='btnradio']:checked").data("id");
            var searchValue = $("#search-input").val();
            view_data(selectedValue, searchValue);
        }
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
