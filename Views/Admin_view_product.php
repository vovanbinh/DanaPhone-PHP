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

            $id = $_GET['id'];

            $sql = "SELECT p.id, p.name, p.price, p.quantity, p.image, p.color,p.describe, p.datecreated, p.status, c.id AS category_id, c.name AS category_name
            FROM product p
            JOIN category c ON p.catalogcode = c.id
            WHERE p.id = '$id'";
            $result = mysqli_query($conn, $sql);

            $response = "";

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $name = $row["name"];
                $price = $row['price'];
                $quantity = $row['quantity'];
                $image = $row['image'];
                $color = $row['color'];
                $datecreated = $row['datecreated'];
                $status = $row['status'];
                $category_id = $row['category_id'];
                $category_name = $row['category_name'];
                $describe = $row['describe'];
            } else {
                echo "Sản Phẩm Không Tồn Tại";
            }
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
                                <div>Thông Tin Sản Phẩm
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="main-card mb-3 col-8 card ">
                            <div class="card-body p-2">
                                <h5 class="card-title">Thêm Mới Sản Phẩm</h5>
                                <form id="formnewproduct">
                                    <div class="position-relative form-group">
                                        <label for="exampleSelect" class="">Danh Mục</label>
                                        <label id="exampleSelect" class="form-control" readonly>
                                            <?php
                                            require_once '../Processing/connect.php';
                                            $sql = "SELECT * FROM category";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                $row = mysqli_fetch_assoc($result);
                                                $id = $row['id'];
                                                $name = $row['name'];
                                                ?>
                                                <lable value="<?php echo $id; ?>">
                                                    <?php echo $category_name; ?>
                                                </lable>
                                                <?php

                                            }
                                            ?>
                                        </label>
                                        <div class="form-group">
                                            <label>Tên Sản Phẩm</label>
                                            <input type="text" class="form-control" readonly value="<?php echo $name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Giá (VND)</label>
                                            <input type="text" class="form-control" readonly value="<?php echo $price; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Số Lượng</label>
                                            <input type="text" class="form-control" readonly value="<?php echo $quantity; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Hình Ảnh</label><br>
                                            <img id="avatar-preview" src="../Public/images/<?php echo $image; ?>"
                                                class="col-2 p-0 mt-2">
                                        </div>
                                        <div class="form-group">
                                            <label>Mô Tả</label>
                                            <textarea id="mota" class="col-12" rows="5"
                                                readonly><?php echo $describe; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Màu</label>
                                            <input type="text" class="form-control" readonly value="<?php echo $color; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày Tạo</label>
                                            <input type="text" class="form-control" readonly
                                                value="<?php echo $datecreated; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng Thái</label>
                                            <input type="text" class="form-control" readonly
                                                value="<?php echo ($status == 0) ? 'Mở Bán' : 'Dự Kiến'; ?>">
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-primary text-white " href="../Views/Admin_product.php">Trở Về</a>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    require_once '../Views/Admin_footer.php';
                    ?>
        </body>

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