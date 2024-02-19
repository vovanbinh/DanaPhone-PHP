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
                            <i class="fas fa-folder"></i>
                            </div>
                            <div>Danh Mục Sản Phẩm<div class="page-title-subheading">Thông tin về các Danh Mục Sản Phẩm!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 col-8 card" style="min-width:495px;">      
                    <div class="row"> 
                        <form class="form-inline mt-3 ml-3" onsubmit="return false;">
                            <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1"  data-id="1" autocomplete="off" >
                                <label class="btn btn-outline-primary" for="btnradio1">Dự Kiến</label>

                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2"  data-id="0"autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio2">Mở Bán</label>
                            </div>
                            <div class="input-group">
                                <input class="form-control mr-3 border-end-0 border rounded-pill" type="search"
                                    id="search-input" placeholder="Search ...">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary mr-2 bg-white border-bottom-0 border rounded-pill ms-n5"
                                        type="submit" id="search-btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div> 
                        </form>
                    </div>
                    <table  class="mt-3 table">
                        <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên Danh Mục</th>
                            <th scope="col">Thương Hiệu</th>
                            <th scope="col">Ngày Tạo</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Thao Tác</th>
                        </tr>
                        </thead>
                        <tbody id="listcategory">
                                
                        </tbody>
                    </table>
            </div>
        <?php
            require_once '../Views/Admin_footer.php';
        ?>
</body>
<script>
    
    $(document).ready(function() {
        view_data();
        $(document).ready(function(){
          $('#table_DM').DataTable();
        });

        function view_data(selectedValue, searchValue) {
            $.post('../processing/adminlistcategory.php',{ selectedValue: selectedValue, searchValue: searchValue }, function(data) {
                $("#listcategory").html(data);
            });
        }
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
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            if (confirm("Bạn có chắc chắn muốn xóa danh mục này không?\nLưu ý: không thể xóa danh mục chứa sản phẩm!")) {
                var requestData = {
                    'id': id,
                };
                $.ajax({
                    method: "POST",
                    url: "../Processing/deletecategory.php",
                    data: requestData,
                    success: function(response) {
                        if(response=="success"){
                            event.preventDefault(); 
                            Toastify({
                                text: "Xóa Danh Mục Thành Công",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", 
                                position: "right", 
                                stopOnFocus: true, 
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function () { }
                            }).showToast();
                            view_data();
                        }
                        else{
                            event.preventDefault(); 
                            Toastify({
                                text: "Không Thể Xóa Danh Mục Này",
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
                    }
                });
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
