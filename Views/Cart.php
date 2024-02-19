<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';
if(isset($_SESSION["username"])){ 
$username = $_SESSION["username"];
?>
<div>
    <div class="hero-depqua mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-excerpt">
                         <h3>Giỏ Hàng Của Bạn</h3>
                         <p class="mb-4">Dana Phone Đà Nẵng: Điểm đến hàng đầu cho các sản phẩm điện thoại chất lượng.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5"  style="min-height:600px;">
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                    <tr >
                        <th  scope="col">STT</th>
                        <th  scope="col">Tên Sản Phẩm</th>
                        <th  scope="col">Đơn Giá</th>
                        <th  class="pl-4" scope="col">Hình Ảnh</th>
                        <th  class="pl-3" scope="col">Số Lượng</th>
                        <th  class="pl-4" scope="col">Thao Tác</th>
                    </tr>
                </thead>
                    <tbody id="listcart">
                                    
                    </tbody>
            </table>
        </div>
        <div class="row">
        <div class="col-md-6 mb-4">
            <div class="row mb-5">
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>
        <?php 
        if(isset($_SESSION['username'])) { 
            require_once '../Processing/connect.php';
            $username = $_SESSION['username'];
            $sql = "SELECT COUNT(*) AS cartItemCount FROM cart WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $cartItemCount = 0;
            if ($result) {
            $row = mysqli_fetch_assoc($result);
            $cartItemCount = $row['cartItemCount'];
            }
            if($cartItemCount>0){
        ?>
        <div class="col-md-6 pl-5 mb-4">
            <div class="row justify-content-end">
            <div class="col-md-7">
                <div class="row">
                <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                </div>
                </div>
                <div class="row mb-3">
                <div class="col-md-6">
                    <span class="text-black">Total: </span>
                </div>
                <div class="col-md-6 text-right">
                     <strong class="text-black cartTotal">
                        <?php
                            require_once '../Processing/connect.php';                
                            $sql = "SELECT SUM(cart.quantity * product.price) AS total FROM cart JOIN product ON cart.idproduct = product.id WHERE username='".$username."'";                
                            $result = mysqli_query($conn, $sql);                
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $total = $row['total'];
                                $formattedPrice = number_format($total, 0, '.', '.').' VND';
                                echo $formattedPrice;
                            } else {
                                echo "0";
                            }
                        ?> 
                    </strong>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <button class="btn-lg py-3 btn-block btn btn-success" onclick="window.location='../views/order.php'">Đặt Hàng</button>
                </div>
                </div>
            </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
        </div>
    </div>
</div>
<?php
require_once "../Views/UserFootter.php";
?>
<script>
function view_data(){
    $.post('../processing/listcart.php', { username: '<?php echo $username; ?>' }, function(data) {
    if(data==""){
        $("#btndathangne").css("display", "none");
    }
    $("#listcart").html(data);
    });
}
$(document).ready(function() {
    view_data();
    $(document).on('input', 'input[id="product-quantity"]', function() {
        inputValue = inputValue.replace(/[^0-9]/g, '');
        inputValue = Math.max(inputValue, 0); 
    });
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '../Processing/deletecart.php', 
            type: 'POST',
            data: {id: id},
            success: function(response) { 
                view_data();
                $.ajax({
                    url: '../Processing/get_Total_cart.php', // Đường dẫn tới tệp PHP xử lý lấy tổng số tiền
                    success: function(newTotal) {
                        $('.cartTotal').text(newTotal); // Cập nhật số tiền hiển thị
                    }
                });
                $.ajax({
                    url: '../Processing/get_Total_cart_menu.php', // Đường dẫn tới tệp PHP xử lý lấy tổng số tiền
                        success: function(newTotal) {
                            $('.totalcartmenu').text(newTotal); // Cập nhật số tiền hiển thị
                        }
                    });
                Toastify({
                    text:  "Xóa Thành Công",
                    duration: 3000,
                    newWindow: true,
                    close: true,
                    gravity: "top", 
                    position: "right", 
                    stopOnFocus: true, 
                    style: {
                        background:  "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    onClick: function () { } 
                }).showToast();
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        var row = $(this).closest('tr'); // Find the parent row of the clicked button
        var id = $(this).data('id');
        var idproduct = $(this).data('idproduct');
        var quantity = row.find('input[name="product-quantity"]').val(); // Find the input element within the current row and get its value

        $.ajax({
            url: '../Processing/editcart.php', 
            type: 'POST',
            data: { id: id, idproduct: idproduct, quantity: quantity },
            success: function(response) { 
                view_data();
                $.ajax({
                    url: '../Processing/get_Total_cart.php', // Đường dẫn tới tệp PHP xử lý lấy tổng số tiền
                    success: function(newTotal) {
                        $('.cartTotal').text(newTotal); // Cập nhật số tiền hiển thị
                    }
                });
                if (response === "true") {
                    Toastify({
                        text:  "Cập Nhật Thành Công",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", 
                        position: "right", 
                        stopOnFocus: true, 
                        style: {
                            background:  "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        onClick: function () { } 
                    }).showToast();
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
        });
    });

    $(document).on('click', '.btn-number', function(e) {
        e.preventDefault();
        var fieldName = $(this).attr('data-field');
        var type = $(this).attr('data-type');
        var input = $(this).closest('tr').find("input[name='" + fieldName + "']"); // Find the input element within the current row
        var currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if (type === 'minus') {
                if (currentVal > 1) {
                    input.val(currentVal - 1).change();
                }
            } else if (type === 'plus') {
                input.val(currentVal + 1).change();
            }
        } else {
            input.val(1);
        }
    });
 });

</script>
<?php
}
?>