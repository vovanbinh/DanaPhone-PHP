<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
?>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src h3 text-nowrap text-success">DANA</div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__content">
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="btn-group">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                            <?php
                                require_once '../Processing/connect.php'; // Đảm bảo đã kết nối CSDL ở đầu file.
                                if(isset($_SESSION['username'])) {
                                    $username = $_SESSION['username'];
                                    $sql = "SELECT image, permission FROM users WHERE username='$username'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $imagead = !empty($row["image"]) ? $row["image"] : 'user.png';
                                    ?>
                                <img width="42" class="rounded-circle" src="../Public/images/<?php echo $imagead; ?>" alt="">
                                <?php
                                }
                                ?>
                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                        </a>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(60px, 43px, 0px);">
                            <label type="button" tabindex="0" class="dropdown-item"><?php echo $username;?> </label>
                            <a tabindex="0" class="dropdown-item"  href="../Views/Editprofile.php">Quản Lí Tài Khoản Cá Nhân</a>
                            <div tabindex="-1" class="dropdown-divider"></div>
                            <a tabindex="0" class="dropdown-item"  href="../Processing/logout.php">Đăng Xuất</a>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                    <ul class="vertical-nav-menu">
                        <li class="app-sidebar__heading">
                            <i class="fas fa-chart-line">
                            </i> Thống Kê</li>
                        <li <?php if ($page == "Sales_chart.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Sales_chart.php">
                                <i class="fas fa-chart-pie">
                                </i> Thống Kê Theo Doanh Thu
                            </a>
                        </li>
                        <li <?php if ($page == "Product_chart.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Product_chart.php">
                                <i class="fas fa-chart-pie">
                                </i> Thống Kê Theo Sản Phẩm
                            </a>
                        </li>
                        <li class="app-sidebar__heading">
                            <i class="fas fa-th-list"></i> Quản Lí Danh Mục</li>
                        <li <?php if ($page == "Admin_new_category.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Admin_new_category.php">
                                <i class="fas fa-folder-plus">
                                </i> Thêm Danh Mục
                            </a>
                        </li>
                        <li <?php if ($page == "Admin_category.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Admin_category.php">
                                <i class="fas fa-folder">
                                </i> Danh Sách Danh Mục
                            </a>
                        </li>
                        <li class="app-sidebar__heading">
                            <i class="fas fa-cube"></i> Quản Lí Sản Phẩm</li>
                        <li  <?php if ($page == "Admin_new_product.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Admin_new_product.php">
                                <i class="fas fa-plus-square">
                                </i> Thêm Sản Phẩm
                            </a>
                        </li>
                        <li <?php if ($page == "Admin_product.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Admin_product.php">
                                <i class="fas fa-folder">
                                </i> Danh Sách Sản Phẩm
                            </a>
                        </li>
                        <li class="app-sidebar__heading">
                            <i class="fas fa-clipboard-list"></i> Quản Lí Đơn Hàng</li>
                        <li  <?php if ($page == "Admin_order.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Admin_order.php">
                                <i class="fas fa-clipboard">
                                </i> Danh Sách Đơn Hàng
                            </a>
                        </li>
                        <li class="app-sidebar__heading">
                            <i class="fas fa-users"></i> Quản Lí Tài Khoản</li>
                        <li <?php if ($page == "Admin_account.php") echo 'class="mm-active"'; ?>>
                            <a style="padding-left: 10px;"  href="../Views/Admin_account.php">
                                <i class="fas fa-user"></i> Danh Sách Tài Khoản
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>


              