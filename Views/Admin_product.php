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
                                    <i class="fas fa-list"></i>
                                </div>
                                <div>Danh Sách Sản Phẩm<div class="page-title-subheading">Tất cả Sản Phẩm có Trong Cửa Hàng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-card mb-3 col-12 card" style="min-width:800px;">
                    <form class="form-inline mt-3 ml-3" onsubmit="return false;">
                        <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio1" id="moban" data-id="0" autocomplete="off">
                            <label class="btn btn-outline-primary" for="moban">Mở Bán</label>

                            <input type="radio" class="btn-check" name="btnradio1" id="dukien" data-id="1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="dukien">Dự Kiến</label>
                        </div>
                        <div class="col-2 mt-3">
                            <input type="range" class="form-range" min="0" max="50000000" step="1000000" id="slider">
                            <div class="mt-2">
                                Từ 0 đến <span id="sliderValue"> 50.000.000</span> VND
                            </div>
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
                            <div class="col-md-12">         
                            <table class="mt-3 table">
                                <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col" class="col-2">Tên Sản Phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Quantily</th>
                                    <th style="padding-left:40px;" scope="col">Image</th>
                                    <th scope="col">Màu</th>
                                    <th scope="col">Ngày Tạo</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Danh Mục</th>
                                    <th style="padding-left: 40px;" scope="col">Thao Tác</th>
                                </tr>
                                </thead>
                                <tbody id="listproduct">
                                        
                                </tbody>
                            </table>
                            </div> 
                        </div> 
                    </div>
<?php
require_once '../Views/Admin_footer.php';
?>
</body>
<script>
    function view_data(selectedValue,searchValue,slidervalue,categoryId){
    $.post('../processing/adminlistproduct.php',{ selectedValue: selectedValue, searchValue: searchValue, slidervalue:slidervalue,categoryId}, function(data) {
    $("#listproduct").html(data);
    });
    }
    $(document).ready(function() {
    view_data();
    let slidervalue = 0; // Giá trị ban đầu của slidervalue 
    //radio
    $("input[name='btnradio1']").on("change", function() {
    var selectedValue = $(this).data("id");
    var searchValue = $("#search-input").val();
    slidervalue = parseInt($("#slider").val()); 
    view_data(selectedValue, searchValue,slidervalue); 
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
            var selectedValue = $("input[name='btnradio1']:checked").data("id");
            slidervalue = parseInt($("#slider").val());
            view_data(selectedValue, searchValue,slidervalue);
        }
    });
    //slider
    const slider = document.getElementById('slider');
    const sliderValue = document.getElementById('sliderValue');
    slider.addEventListener('input', function() {
        var slidervalue = this.value;
        var formattedValue = slidervalue === '0' ? 'VND' : new Intl.NumberFormat('vi-VN', {currency: 'VND' }).format(slidervalue);
        sliderValue.innerText = formattedValue;
        var selectedValue = $("input[name='btnradio1']:checked").data("id");
        var searchValue = $("#search-input").val();
        view_data(selectedValue, searchValue,slidervalue);
    });
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?\nLưu ý: không thể xóa sản phẩm nằm trong giỏ hàng khách hàng!")) {
            var requestData = {
                'id': id,
            };
            $.ajax({
                method: "POST",
                url: "../Processing/deleteproduct.php",
                data: requestData,
                success: function(response) {
                    if(response=="success"){
                            event.preventDefault(); 
                            Toastify({
                                text: "Xóa Sản Phẩm Thành Công",
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
                            text: "Không Thể Xóa Sản Phẩm Này",
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