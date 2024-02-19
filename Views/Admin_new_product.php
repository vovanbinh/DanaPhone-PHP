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
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div>Thêm Sản Phẩm Mới<div class="page-title-subheading">Thêm mới Sản Phẩm của cửa hàng!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="main-card mb-3 col-8 card ">
                            <div class="card-body ">
                                <h5 class="card-title">Thêm Mới Sản Phẩm</h5>
                                <form id="formnewproduct">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Danh Mục</label>
                                        <select id="exampleSelect" class="form-control">
                                            <option value="">Chọn danh mục</option>
                                            <?php
                                            require_once '../Processing/connect.php';
                                            $sql = "SELECT * FROM category";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id = $row['id']; // Lấy id của danh mục
                                                    $name = $row['name']; // Lấy tên của danh mục
                                                    ?>
                                                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="form-group">
                                            <label>Tên Sản Phẩm</label>
                                            <label class="text-warning" id="ername"></label>
                                            <input type="text" class="form-control" id="tensanpham">
                                        </div>
                                        <div class="form-group">
                                            <label>Giá (VND)</label>
                                            <label class="text-warning" id="ergia"></label>
                                            <input type="text" class="form-control" id="gia">
                                        </div>
                                        <div class="form-group">
                                            <label>Số Lượng</label>
                                            <label class="text-warning" id="ersoluong"></label>
                                            <input type="text" class="form-control" id="soluong">
                                        </div>
                                        <div class="form-group">
                                            <label>Hình Ảnh</label>
                                            <input type="file" id="anh" class="form-control-file">
                                            <img id="avatar-preview" class="col-4 p-0 mt-2">
                                        </div>
                                        <div class="form-group">
                                            <label>Mô Tả</label>
                                            <label class="text-warning" id="ermota"></label>
                                            <textarea id="mota" class="col-12" rows="5"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Màu</label>
                                            <label class="text-warning" id="ermau"></label>
                                            <input type="text" class="form-control" id="mau">
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày Tạo</label>
                                            <input type="text" class="form-control" id="ngaytao"
                                                value="<?php echo date('Y-m-d'); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng Thái</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="trangthai" value="0" checked>
                                                <label class="form-check-label ml-2" for="mo-ban">
                                                    Mở Bán
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="trangthai" value="1">
                                                <label class="form-check-label ml-2" for="du-kien">
                                                    Dự Kiến
                                                </label>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-primary text-white mb-3 mr-5" href="../Views/Admin_product.php">Trở
                                                Về</a>
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
        document.getElementById('anh').addEventListener('change', function(event) {
            var fileInput = event.target;
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var previewImage = document.getElementById('avatar-preview');
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
        $(document).ready(function () {
            $('#exampleSelect').on('change', function () {
                var selectedValue = $(this).val();
                $(this).find('option[value=""]').remove(); // Ẩn tùy chọn "Chọn danh mục"

            });
            $('input[id="gia"]').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            $('input[id="soluong"]').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            $("#formnewproduct").submit(function (event) {
                event.preventDefault();
                var selectedCategoryId = $('#exampleSelect').val(); // Lấy mã danh mục đã chọn
                if (selectedCategoryId === "") {
                    event.preventDefault(); // Ngăn chặn thực hiện tải trang
                    Toastify({
                        text: "Vui Lòng Chọn Danh Mục",
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
                    return;
                }
                var formData = new FormData();
                formData.append('madanhmuc', selectedCategoryId);
                formData.append('tensanpham', $('#tensanpham').val());
                formData.append('gia', $('#gia').val());
                formData.append('soluong', $('#soluong').val());
                formData.append('anh', $('#anh')[0].files[0]);
                formData.append('mota', $('#mota').val());
                formData.append('mau', $('#mau').val());
                formData.append('ngaytao', new Date().toISOString());
                formData.append('trangthai', $('input[name="trangthai"]:checked').val());

                $.ajax({
                    url: '../Processing/addnewproduct.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        var customresoponse = "";
                        if (response == 200) {
                            window.location.href = '../views/Admin_product.php';
                        } else if (response == "nullname") {
                            customresoponse= "Vui lòng nhập tên";
                        } else if (response == "nullgia") {
                            customresoponse="Vui lòng nhập giá tiền";
                        } else if (response == "nullsoluong") {
                            customresoponse="Vui lòng nhập số lượng";
                        } else if (response == "nullmota") {
                            customresoponse="Vui lòng nhập mô tả";
                        } else if (response == "nullmau") {
                            customresoponse="Vui lòng nhập màu";
                        } else {
                            customresoponse = response;   
                        }
                        event.preventDefault(); // Ngăn chặn thực hiện tải trang
                        Toastify({
                            text: customresoponse,
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top", // Change this to "top"
                            position: "right", // Leave this as "right"
                            stopOnFocus: true,
                            style: {
                                background: "red",
                            },
                            onClick: function () { } // Callback after click
                        }).showToast();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Lỗi',
                            text: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
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