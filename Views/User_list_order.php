<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    ?>
    <div>
        <div class="hero-depqua mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-excerpt">
                            <h3>Danh Sách Đơn Hàng Của Bạn</h3>
                            <p class="mb-4">Dana Phone Đà Nẵng: Điểm đến hàng đầu cho các sản phẩm điện thoại chất lượng.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="row ">
                <table class="table ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col" class="col-md-2">Ngày Order</th>
                            <th scope="col" class="col-md-2">Tên người nhận</th>
                            <th scope="col">Tổng</th>
                            <th scope="col" class="col-md-2">Thanh Toán</th>
                            <th scope="col" class="col-md-2">Trạng thái</th>
                            <th scope="col" class="col-md-1">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="listuseroder">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-5 border">

        </div>
        <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customoMdalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customModalLabel">Xác Nhận</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <h3>Bạn muốn Hủy Đơn Hàng Này?</h1>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirm-delete-btn" data-bs-dismiss="modal"
                            class="btn btn-success">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once "../Views/UserFootter.php";
    ?>
    <script>
        function view_data() {
            $.post('../processing/listuseroder.php', function (data) {
                $("#listuseroder").html(data);
            });
        }

        $(document).ready(function () {
            view_data();
            $(document).on('click', '.cancel-btn', function () {
                var id = $(this).data('id');
                $('#customModal').modal('show');
                $('#confirm-delete-btn').off('click').on('click', function () {
                    var action = "delete";
                    $.ajax({
                        url: '../processing/approve_or_delete_order.php',
                        type: 'POST',
                        data: { id: id, action: action },
                        success: function (response) {
                            if (response === "Hủy Đơn Hàng Thành Công") {
                                Toastify({
                                    text: "Hủy Đơn Hàng Thành Công",
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
                            } else {
                                console.log(response);
                                Swal.fire({
                                    title: 'Lỗi',
                                    text: response,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        });
    </script>
    <?php
}
?>