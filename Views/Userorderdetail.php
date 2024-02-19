<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';
if(isset($_SESSION["username"])){ 
$username = $_SESSION["username"];
?>
    <div class="container py-5 h-100 mb-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <?php
            require_once '../Processing/connect.php';
            $idorder = $_GET["id"];
            $sql = "SELECT oder.id,oder.order_status, oder.create_at, info_ship.fullname, info_ship.phonenumber, info_ship.address, SUM(product.price * order_detail.product_quantity) as total, oder.payment_status, oder.admin_status, product.name, product.image, product.color, order_detail.product_quantity
            FROM oder
            JOIN info_ship ON info_ship.id = oder.id_info_ship
            JOIN order_detail ON order_detail.oder_id = oder.id
            JOIN product ON order_detail.product_id = product.id
            WHERE oder.username = '$username' AND oder.id = '$idorder'
            GROUP BY oder.id, oder.create_at, info_ship.fullname, info_ship.phonenumber, info_ship.address, oder.payment_status,oder.order_status , oder.admin_status, product.name, product.price, product.image, product.color, order_detail.product_quantity";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $create_at = $row["create_at"];
                $fullname = $row['fullname'];
                $phonenumber = $row['phonenumber'];
                $address = $row['address'];
                $payment_status = $row['payment_status'];
                $admin_status = $row['admin_status'];    
                $order_status = $row['order_status'];            
            ?>
                <div class="col-lg-11 col-xl-8 ">
                    <div class="card col-12 p-0 " style="border-radius: 10px;">
                        <div class="card-header  col-12 px-4 py-5">
                            <h5 class="text-muted mb-0">Thanks for your Order, <span style="color: #FA5882;"><?php echo $username; ?></span>!</h5>
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
                            <div class="card col-12 shadow-0 border mb-4">
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
                                            <p class="text-muted mb-0 small"><?php $formattedPrice =  number_format($total, 0, '.', '.').' VND'; echo $formattedPrice;?></p>
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
                                <?php } else { ?>
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
                                        <p class="text-muted mb-2"><span class="fw-bold text-primary">Chưa Phê Duyệt</span></p>
                                    </div>
                                <?php } else if ($admin_status == 1 && $order_status !=1) { ?>
                                    <div class="col-md-8">
                                        <p class="text-muted mb-2"><span class="fw-bold text-success">Đã Phê Duyệt</span></p>
                                    </div>
                                <?php } else if ($admin_status == 2) { ?>
                                    <div class="col-md-8">
                                        <p class="text-muted mb-2"><span class="fw-bold text-danger">Đơn Hàng Đã Bị Hủy</span></p>
                                    </div>
                                <?php } else if ($order_status == 1 && $admin_status == 1) { ?>
                                    <div class="col-md-8">
                                        <p class="text-muted mb-2"><span class="fw-bold text-info">Đã Nhận Hàng</span></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer col-12 border-0 px-4 py-5" style="background-color: #FA5882; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">
                                Tổng Tiền: <span class="h2 mb-0 ms-2"><?php $formattedPrice = number_format($total, 0, '.', '.').' VND';; echo $formattedPrice; ?></h5>
                        </div>
                    </div>
                </div>

            <?php          
            } 
                mysqli_close($conn);
            ?>
        </div>
    </div>
<?php
    require_once '../Views/UserFootter.php';
?>
<script>
</script>
<?php
}
?>