<!doctype html>
<html lang="en">

<head>
    <?php
    session_start();
    require_once '../Processing/connect.php';
    if (isset($_SESSION['username'])) {
        $usernamess = $_SESSION['username'];
        $sql = "SELECT * FROM users WHERE username= '$usernamess' AND permission = '1'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            require_once '../Views/Admin_head.php';
            if (isset($_GET['username'])) {
                $usernameurl = $_GET['username'];
                $sql = "SELECT * FROM users WHERE username= '$usernameurl'";
                $result = mysqli_query($conn, $sql);
            
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $usernamecheck = $row["username"];
                    $name = $row['name'];
                    $phone = $row['phone'];
                    $image = !empty($row["image"]) ? $row["image"] : 'user3.png';
                    $email = $row['email'];
                    $permission = $row['permission'];
                    $datecreated = $row['datecreated'];
                    $vertifid = $row['vertified'];
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
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>Thông Tin Người Dùng<div class="page-title-subheading"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 justify-content-center">
                        <div class="main-card col-8 card mb-3 justify-content-center" >
                            <div class="row ml-1 col-12 justify-content-center">
                                <div class="col-12 justify-content-center">
                                    <h3 class="text-center mt-3">Thông Tin Người Dùng</h3>
                                    <div class="text-center mt-3 ">
                                        <img  alt="Ảnh người dùng" class="col-3 rounded-circle" src="../Public/images/<?php echo $image;?>"></img>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 text-right">
                                            <p class="text-muted mb-2 mt-3"><strong>Tên Người dùng:</strong></p>
                                        </div>
                                        <div class="col-6 text-left ">
                                            <p class="text-muted mb-2  mt-3"><?php echo $name;?></p>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 text-right">
                                            <p class="text-muted mb-2"><strong>Số Điện Thoại</strong></p>
                                        </div>
                                        <div class="col-6 text-left">
                                            <p class="text-muted mb-2"><?php echo $phone; ?></p>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 text-right">
                                            <p class="text-muted mb-2"><strong>Email:</strong></p>
                                        </div>
                                        <div class="col-6 text-left">
                                            <p class="text-muted mb-2"><?php echo $email; ?></p>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 text-right">
                                            <p class="text-muted mb-2"><strong>Phân Quyền:</strong></p>
                                        </div>
                                        <div class="col-6 text-left">
                                            <p class="text-muted mb-2"><?php if($permission==1) echo "Admin"; else if($permission==0) echo "Khách Hàng"; else Echo "Null";?></p>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 text-right">
                                            <p class="text-muted mb-2"><strong>Trạng Thái Tài Khoản:</strong></p>
                                        </div>
                                        <div class="col-6 text-left">
                                            <p class="text-muted mb-2"><?php if($vertifid==1) echo "Đã xác thực"; else if($permission==0) echo "Chưa xác thực"; else Echo "Null";?></p>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 text-right">
                                            <p class="text-muted mb-2"><strong>Ngày tạo:</strong></p>
                                        </div>
                                        <div class="col-6 text-left">
                                            <p class="text-muted mb-2"><?php echo $datecreated; ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right mt-5">
                                        <a class="btn btn-primary text-white mb-3"href="../Views/Admin_account.php">Trở Về</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    require_once '../Views/Admin_footer.php';
                    }
                    else{
                        echo "usename không tồn tại";
                    }
                    ?>
        </body>
        <script>
$(document).ready(function() { 
    $(document).on("click", "#update-btn", function(event) {
    var permission = $("input[name='permission']:checked").val();
    var username = "<?php  echo $usernamecheck; ?> "
      $.ajax({
        url: '../processing/Admin_update_user.php',
        type: 'POST',
        data: {
          username: username, 
          permission: permission
        },
        success: function(response) {
            if (response == 200) {
                window.location.href = '../views/Admin_account.php';
            } else {
                event.preventDefault(); 
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