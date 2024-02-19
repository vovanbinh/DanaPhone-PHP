<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="../Public/images/favicon.ico">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  -->
    <link href="../Public/css/main.css" rel="stylesheet">
    <link href="../Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../Public/css/tiny-slider.css" rel="stylesheet">
    <link href="../Public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../Public/css/toastyfi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <title>DANA PHONE</title>
	</head>
	<body>
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
			<div class="container">
				<a class="navbar-brand" href="../Views/index.php">DANA PHONE<span>.</span></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsFurni">
                    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item <?php if ($page == "index.php") echo 'active'; ?>">
                            <a class="nav-link" href="../Views/index.php">Trang Chủ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?php if ($page == "category.php") echo 'active'; ?>" href="#" id="navbarDropdownShop" role="button" data-bs-toggle="dropdown" aria-expanded="false">Danh Mục</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownShop">
                                <?php
                                require_once '../Processing/connect.php';
                                $sql = "SELECT * FROM category WHERE status = 0";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $name = $row['name'];
                                    $id = $row['id'];
                                ?>
                                <li>
                                    <a class="dropdown-item" style="background-color: black;" href="../Views/Category.php?idcategory=<?php echo $id; ?>">
                                        <?php echo $name; ?>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item <?php if ($page == "shop.php") echo 'active'; ?>">
                            <a class="nav-link" href="../views/shop.php">Cửa Hàng</a>
                        </li>
                        <li class="nav-item">
                            <form  class="form-inline " onsubmit="return false;">
                                <div class="input-group">
                                    <input  style="max-height:40px;" class="form-control mr-3 border-end-0 border rounded-pill" type="search"
                                        id="search-input" placeholder="Tìm Kiếm ...">
                                    <span class="input-group-append">
                                        <button  style="max-height:40px; padding-bottom: 30px;" class="btn btn-outline-secondary border-bottom-0 rounded-pill "
                                            type="submit" id="search-btn">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </li>
                    </ul>
                    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                        <li class="nav-item dropdown">
                        <?php
                            require_once '../Processing/connect.php'; // Đảm bảo đã kết nối CSDL ở đầu file.
                            if(isset($_SESSION['username'])) {
                                $username = $_SESSION['username'];
                                $sql = "SELECT image, permission FROM users WHERE username='$username'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $image = !empty($row["image"]) ? $row["image"] : 'user.png';
                                ?>
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img style="max-width: 50px; max-height: 50px; border-radius: 50%;" src="../Public/images/<?php echo $image; ?>" alt="Image">
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                                    <p style="margin:0;"class="dropdown-item"><?php echo $username; ?></p>
                                    <li><a class="dropdown-item" href="../views/Editprofile.php">Quản Lí Tài Khoản Cá Nhân</a></li>
                                    <li><a class="dropdown-item" href="../views/User_list_Order.php">Quản Lí Đơn Hàng Cá Nhân</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../Processing/logout.php">Đăng xuất</a></li>
                                </ul>
                                <?php
                            } 
                            else {
                                ?>
                                <a class="nav-link" href="../Views/Login_And_Register.php">
                                    <img style="max-width: 50px; max-height: 50px; border-radius: 50%;" src="../Public/images/user.png" alt="Image">
                                </a>
                                <?php
                            }
                        ?> 
                        </li>
                        <?php if(isset($_SESSION['username'])) { 
                            require_once '../Processing/connect.php';
                            $username = $_SESSION['username'];
                            $sql = "SELECT COUNT(*) AS cartItemCount FROM cart WHERE username = '$username'";
                            $result = mysqli_query($conn, $sql);
                            $cartItemCount = 0;
                            if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $cartItemCount = $row['cartItemCount'];
                        }
                        ?>
                        <li> 
                            <a class="nav-link mt-2" href="../views/Cart.php">
                                <img src="../Public/images/cart.svg" alt="Image">
                                <?php if ($cartItemCount >= 0): ?>
                                     <span class="badge badge-danger position-absolute totalcartmenu rounded-circle"><?= $cartItemCount ?></span>
                                <?php endif; }?>
                            </a>
                        </li>
                    </ul>
                </div>

			</div>
		</nav>