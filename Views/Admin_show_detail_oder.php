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
            <div class="app-page-title mb-0">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>Thông tin chi tiết đơn hàng
                        </div>
                    </div>
                </div>
            </div>
                <form class="showinfo">
                    <div class="container">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <?php
                            require_once '../Processing/connect.php';
                            $idorder = $_GET["id"];
                            $sql = "SELECT oder.id, oder.order_status, oder.create_at, info_ship.fullname,info_ship.phonenumber, info_ship.address, SUM(product.price * order_detail.product_quantity) as total, oder.payment_status, oder.admin_status, product.name, product.image, product.color, order_detail.product_quantity
                            FROM oder
                            JOIN info_ship ON info_ship.id = oder.id_info_ship
                            JOIN order_detail ON order_detail.oder_id = oder.id
                            JOIN product ON order_detail.product_id = product.id
                            WHERE oder.id = '$idorder'
                            GROUP BY oder.id, oder.create_at, info_ship.fullname, info_ship.phonenumber, info_ship.address, oder.payment_status, oder.admin_status, product.name, product.price, product.image, product.color, order_detail.product_quantity";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $create_at = $row["create_at"];
                                $orderid = $row["id"];
                                $fullname = $row['fullname'];
                                $phonenumber = $row['phonenumber'];
                                $address = $row['address'];
                                $payment_status = $row['payment_status'];
                                $admin_status = $row['admin_status'];  
                                $order_status = $row['order_status'];  
                            
                            ?>
                                <div class="col-9">
                                    <div class="card" style="border-radius: 10px;">
                                        <div class="card-header px-4 py-5">
                                            <h5 class="text-muted mb-0">MÃ ĐƠN HÀNG: <span class="fw-bold "style="color: #FA5882;"><?php echo $orderid; ?></span></h5>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="lead fw-normal mb-0" style="color: #FA5882;">Chi Tiết Đơn Hàng</h5>
                                            </div>
                                            <?php 
                                            mysqli_data_seek($result, 0);
                                            $totalall = 0;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $product_quantity = $row['product_quantity'];
                                                $image = $row['image'];
                                                $name = $row['name'];
                                                $color = $row['color'];
                                                $total = $row['total'];
                                                $totalall += $row['total'];
                                            ?>
                                            <div class="card shadow-0 border mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img src="../Public/images/<?php echo $image;?>" class="img-fluid" alt="Phone">
                                                        </div>
                                                        <div class="col-md-4 d-flex align-items-center">
                                                            <p class="text-muted mb-0"><?php echo $name;?></p>
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-center">
                                                            <p class="text-muted mb-0 small"><?php echo $color;?></p>
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-center">
                                                            <p class="text-muted mb-0 small">Quantity: <?php echo $product_quantity; ?></p>
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-center">
                                                            <p class="text-muted mb-0 small"><?php $formattedPrice = number_format($total, 0, '.', '.').' VND'; echo $formattedPrice;?></p>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="d-flex justify-content-between pt-2">
                                                <h5 class="text-muted mb-4">Thông Tin Nhận Hàng</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Tên Người Nhận:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><span class="fw-bold text-body"><?php echo $fullname;?></span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Số Điện Thoại:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><?php echo $phonenumber;?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Địa Chỉ Nhận Hàng:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><span class="fw-bold text-body"><?php echo $address;?></span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Ngày Đặt Hàng:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><?php echo $create_at;?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Trạng Thái Thanh Toán:</p>
                                                </div>
                                                <?php if ($payment_status == 0) { ?>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><span class="fw-bold text-body">Chưa Thanh Toán</span></p>
                                                </div>
                                                <?php } else if ($payment_status == 1) { ?>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><span class="fw-bold text-body">Đã Thanh Toán</span></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Trạng Thái Đơn Hàng:</p>
                                                </div>
                                                <?php if ($admin_status == 0) { ?>
                                                    <div class="col-md-8">
                                                        <p class="text-muted mb-2"><span class="fw-bold text-body">Chưa Phê Duyệt</span></p>
                                                    </div>
                                                <?php } else if ($admin_status == 1 && $order_status !=1) { ?>
                                                    <div class="col-md-8">
                                                        <p class="text-muted mb-2"><span class="fw-bold text-body">Đã Phê Duyệt</span></p>
                                                    </div>
                                                <?php } else if ($admin_status == 2) { ?>
                                                    <div class="col-md-8">
                                                        <p class="text-muted mb-2"><span class="fw-bold text-body">Đơn Hàng Đã Bị Hủy</span></p>
                                                    </div>
                                                <?php } else if ($order_status == 1 && $admin_status == 1) { ?>
                                                    <div class="col-md-8">
                                                        <p class="text-muted mb-2"><span class="fw-bold text-body">Đã Nhận Hàng</span></p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="text-muted mb-2">Tổng Tiền:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-muted mb-2"><span class="fw-bold text-body"><?php $formattedPrice = number_format($totalall, 0, '.', '.').' VND'; echo $formattedPrice  ;?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if($admin_status==0){?>                            
                                        <div class="card-footer border-0 px-2 py-2" style="background-color: #FA5882; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-success approve-btn mr-1" data-id="<?php echo $orderid; ?>">Phê Duyệt</button>                      
                                                <button class="btn btn-warning delete-btn " data-id="<?php echo $orderid; ?>">Hủy Đơn Hàng</button>  
                                                <a href="../views/Adminorder.php"class="btn ml-2 btn-info">Trở Lại</a>             
                                            </div>
                                        </div>
                                        <?php
                                        }else if($admin_status==1 && $order_status !=1){
                                        ?>
                                        <div class="card-footer border-0 px-2 py-2" style="background-color: #FA5882; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <div class="d-flex justify-content-end">             
                                                <button class="btn btn-success thanhtoan-btn " data-id="<?php echo $orderid; ?>">Xác Nhận Giao Hàng Thành Công</button>
                                                <a href="../views/Admin_order.php"class="btn ml-2 btn-info">Trở Lại</a>               
                                            </div>
                                        </div>
                                        <?php
                                        }else {?> 
                                        <div class="card-footer border-0 px-2 py-2" style="background-color: #FA5882; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <div class="d-flex justify-content-end">             
                                                <a href="../views/Admin_order.php"class="btn btn-success">Trở Lại</a>             
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php          
                            } 
                                mysqli_close($conn);
                            ?>
                        </form>
                    </div>
                </div>
            <?php
            require_once '../Views/Admin_footer.php';
            ?>
    </body>
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                event.preventDefault();
                var id = $(this).data('id'); 
                showConfirmDialog("Hủy Đơn Hàng", id, 'delete'); 
            });
            $('.approve-btn').click(function() {
                event.preventDefault();
                var id = $(this).data('id'); 
                showConfirmDialog("Phê Duyệt Đơn Hàng", id, 'approve'); 
            });
            $('.thanhtoan-btn').click(function() {
                event.preventDefault();
                var id = $(this).data('id'); 
                showConfirmDialog("Xác Nhận Giao Hàng Thành Công", id, 'thanhtoan'); 
            });
            
            function showConfirmDialog(actionName, id, action) {
                var confirmation = confirm("Bạn có chắc chắn muốn " + actionName + "?");
                if (confirmation) {
                    processData(id, action);
                }
            }

            function processData(id, action) {
                $.ajax({
                    url: '../Processing/approve_or_delete_order.php',
                    type: 'POST',
                    data: {
                        id: id,
                        action: action
                    },
                    success: function(response) {
                        if (response == "Phê Duyệt Đơn Hàng Thành Công" || response == "Hủy Đơn Hàng Thành Công" || response ==201) {
                            window.location.reload();
                        } else {
                            Toastify({
                                text: response,
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
                    },
                });
            }
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