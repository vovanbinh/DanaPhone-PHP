<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select *, product.name as name  from product,category where product.catalogcode=category.id and product.id= '" . $id . "' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $price = $row['price'];
        $formattedPrice = number_format($price, 0, '.', '.').' VND';
        $trademark = $row['trademark'];
        $describe = $row['describe'];
        $image = $row['image'];
        $color = $row['color'];
        $quantity = $row['quantity'];
        ?>
        <div class="hero-depqua mb-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="intro-excerpt">
						<h3>Chi Tiết Sản Phẩm</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div>
            <div class="container mb-5">
                <div class="row ">
                    <div class=" ml-5 col-md-4 ">
                        <img src="../Public/images/<?php echo $image; ?>" alt="Product Image" class="img-fluid">
                    </div>
                    <div class="col-md-7 border rounded shadow mb-5">
                        <h2 class="mb-3 mt-3">
                            <?php echo $name; ?>
                        </h2>
                        <p class="lead mb-3"><strong>Giá Bán:
                                <?php echo $formattedPrice; ?>
                            </strong></p>
                        <p class="mb-3"><strong>Mô Tả: </strong><br>
                            <?php echo $describe; ?>
                        </p>
                        <p class="mb-3"><strong>Thương Hiệu: </strong>
                            <?php echo $trademark; ?>
                        </p>
                        <p class="mb-3"><strong>Màu Sắc: </strong>
                            <?php echo $color; ?>
                        </p>
                        <p class="mb-3"><strong>Số Lượng Hiện Có: </strong>
                            <?php echo $quantity; ?>
                        </p>
                        <form method="POST">
                            <input type="hidden" id="idproduct" value="<?php echo $_GET['id']; ?>">
                            <div class="p-0 input-group mb-3 d-flex align-items-center quantity-container col-2" ">
                                <div>
                                    <button style=" max-height:30px; border:0.5px solid #DCDCDC; background-color:white;"
                                data-field="product-quantity" class="btn-number" data-type="minus" type="button">−</button>
                            </div>
                            <input id="product-quantity" style="padding:0;  max-height:30px;" type="number"
                                class="form-control text-center" value="1">
                            <div>
                                <button style=" max-height:30px; border:0.5px solid #DCDCDC; background-color:white;"
                                    data-field="product-quantity" class="btn-number" data-type="plus" type="button">+</button>
                            </div>
                    </div>
                    <button style="padding:10px;" id="addtocart" type="button" class="btn mb-3 btn-primary">Thêm Vào Giỏ
                        Hàng</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo '<p style="min-height: 500px;" class="ml-5 text-danger mt-5">Không Có Sản Phẩm Này</p>';
    }
} else {
    echo '<p style="min-height: 500px;" class="ml-5 text-danger mt-5">Không Tồn Tại Id Sản Phẩm</p>';
}
mysqli_close($conn);
require_once "../Views/UserFootter.php";
?>
<script>
    $(document).ready(function () {
        $('#product-quantity').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $(document).on('click', '#addtocart', function () {
            var id = $('#idproduct').val();
            var quantity = $('input[id="product-quantity"]').val();
            $.ajax({
                type: 'POST',
                url: '../Processing/addtocart.php',
                data: { id: id, quantity: quantity },
                dataType: 'json',
                success: function (response) {
                    var color = "red";
                    if (response.message == "true") {
                        var color = "linear-gradient(to right, #00b09b, #96c93d)";
                        response.message = "Thêm Thành Công";
                    }
                    $.ajax({
                        url: '../Processing/get_Total_cart_menu.php', // Đường dẫn tới tệp PHP xử lý lấy tổng số tiền
                        success: function (newTotal) {
                            $('.totalcartmenu').text(newTotal); // Cập nhật số tiền hiển thị
                        }
                    });
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        // destination: "https://github.com/apvarun/toastify-js",
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background: color,
                        },
                        onClick: function () { } // Callback after click
                    }).showToast();
                    // $('#result').text(response.message);
                },
                error: function () {
                    $('#result').text('An error occurred during the AJAX request.');
                }
            });
        });

        // Xử lý sự kiện click nút (+)
        $(document).on('click', '.btn-number', function (e) {
            e.preventDefault();
            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[id='" + fieldName + "']");
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