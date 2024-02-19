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
                        <div>Danh Sách Đơn Hàng<div class="page-title-subheading">Tất cả đơn đặt hàng của khách hàng!</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <form class="form-inline mt-3 ml-3" onsubmit="return false;">
                    <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
                        <!-- Nhóm thứ nhất -->
                        <input type="radio" class="btn-check" name="btnradio1" id="ad0" data-id="ad0" autocomplete="off">
                        <label class="btn btn-outline-primary" for="ad0">Chưa Phê Duyệt</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="ad1" data-id="ad1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="ad1">Đã Phê Duyệt</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="ad2" data-id="ad2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="ad2">Đã Hủy</label>

                        <input type="radio" class="btn-check" name="btnradio1" id="od1" data-id="od1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="od1">Thành Công</label>
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
                                <th scope="col">Mã</th>
                                <th scope="col">Username</th>
                                <th scope="col">Payment method</th>
                                <th scope="col">Ngày Mua</th>
                                <th scope="col">Trạng Thái</th>
                                <th style="padding-left:40px;" scope="col">Thao Tác</th>
                            </tr>
                            </thead>
                            <tbody id="listorder"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            require_once '../Views/Admin_footer.php';
            ?>
    </body>
    <script>
    function view_data(selectedValue, searchValue) {
        $.post('../processing/adminlistorder.php',{ selectedValue: selectedValue, searchValue: searchValue }, function(data) {
        $("#listorder").html(data);
        });
    }
    $(document).ready(function() {
    view_data();
    $("input[name='btnradio1']").on("change", function() {
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
                var selectedValue = $("input[name='btnradio1']:checked").data("id");
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