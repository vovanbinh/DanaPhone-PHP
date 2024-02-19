<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';
if(isset($_SESSION["username"])){ 
$username = $_SESSION["username"];
?>
<div class="untree_co-section">
<?php 
        require_once '../Processing/connect.php';
        $sql = "select * from cart where username = '".$username."'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) == 0) {
        echo '<h2 class="ml-3 text-danger"> Vui Lòng Thêm Sản Phẩm </h2>';
        }
        else{
    ?>
<div class="container">
	<div class="row mb-5">
		<div class="col-md-12">
			<div class="border p-4 rounded" role="alert">
				<h2>Trang Thanh Toán</h2>
				Bạn Muốn Thay Đổi Đơn Hàng? </strong><a href="../Views/Cart.php">Quay Lại</a> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 mb-5 mb-md-0">
			<h2 class="h3 mb-3 text-black">Thêm Mới Thông Tin Nhận Hàng</h2>
			<div class="p-3 p-lg-5 border bg-white">
			<div class="form-group">
				<label  class="text-black">Tên Người Nhận<span class="text-danger">*</span></label>
				<label class="text-warning" id="ername"> </label>
				<input type="text" class="form-control" id="newname" placeholder="Nhập tên người nhận" >
			</div>
			<div class="form-group row">
				<div class="col-md-12">
				<label  class="text-black">Số điện thoại<span class="text-danger">*</span></label>
				<label class="text-warning" id="erphone"> </label>
				<input type="text" class="form-control" id="newphone" placeholder="Nhập số điện thoại" >
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
				<label for="c_address" class="text-black">Địa Chỉ Nhận Hàng (Số Nhà, Tên Đường, Huyện, Tỉnh) <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="newaddress" name="newaddress" placeholder="Nhập Địa Chỉ Nhận Hàng">
				</div>
			</div>
			<div class="form-group ">
				<button type="button" class="btn btn-black addNewAddressBtn btn-block">Thêm Mới Thông Tin Nhận Hàng</button>
			</div>
			</div>
		</div>
		<div class="col-md-6 mb-5">
			<div class="row mb-5">
				<div class="col-md-12">
					<h2 class="h3 mb-3 text-black">Chọn Thông Tin Nhận Hàng</h2>
					<div class="p-3 p-lg-5 border bg-white">
					<label for="c_code" class="h4 text-black mb-3">Vui lòng chọn 1 thông tin nhận hàng!</label><br>
					<label for="c_code" class="text-danger mb-3">(Tên người nhận, số điện thoại, địa chỉ)</label>
					<div class="form-check" id="showin_fo">
					</div>
					<div class=" mt-5">
						<button type="button" class="btn btn-warning macdinhinfo">Đặt Làm Mặc Định</button>
						<button type="button" class="btn btn-success capnhatinfo" id="btnthaydoi">Chọn Làm Địa Chỉ Nhận Hàng</button>
					</div>
					</div>
				</div>
			</div>
			<div class="row mb-5">
			<div class="col-md-12">
				<h2 class="h3 mb-3 text-black">Thông tin Đơn Hàng Của Bạn</h2>
				<div class="p-3 p-lg-5 border bg-white">
					<table class="table site-block-order-table mb-5">
						<thead>
							<th>Tên Sản Phẩm</th>
							<th>Số Lượng</th>
							<th>Tổng Tiền</th>
						</thead>
						<tbody id="listcart">
						</tbody>
					</table>
						<div class="row total-row mt-3 pt-3 border-top ">
							<div class="col-md-4 text-black font-weight-bold"><strong>Tổng Tiền Thanh Toán:</strong></div>
							<div class="col-md-4 text-black font-weight-bold"><strong>
							<?php
								require_once '../Processing/connect.php';
								$sql = "SELECT sum(cart.quantity * product.price) AS total
											FROM cart
											JOIN product ON cart.idproduct = product.id
											WHERE cart.username = '" . $username . "'";
								$result = mysqli_query($conn, $sql);
								if ($result && mysqli_num_rows($result) > 0) {
									$row = mysqli_fetch_assoc($result);
									$totalprice = $row['total'];
									$formattedPrice = number_format($totalprice, 0, '.', '.').' VND';
									echo $formattedPrice;
								} else {
									echo "0 $";
								}
								?>
							</strong></div>
						</div>
						<div class="row info-row border-bottom pb-3">
							<div class="col-md-4 text-black font-weight-bold"><strong>Địa Chỉ Nhận Hàng:</strong></div>
							<div class="col-md-8 text-black" id="info"></div>
						</div>
						<div class="form-group text-center mt-3" id="payment-section">
							<div class="row">
								<div class="col-6 mb-3">
								<button type="button" id="thanhtoankhinhanhang" class="btn btn-success mb-3 col-12" data-bs-toggle="modal" data-bs-target="#confirmModal">Thanh Toán COD!</button>
								</div>
								<div class="col-6">
									<div id="paypal-button-container"></div>
								</div>
							</div>
						</div>
						<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="confirmModalLabel">Xác Nhận Thanh Toán</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										Bạn có muốn thanh toán khi nhận hàng hay không?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
										<button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="confirm-payment-btn">Có</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
require_once "../Views/UserFootter.php";
?>
<script>
	function show_info_ship_model() {
        $.post('../processing/show_infoship_model.php', function(response) {
            $("#showin_fo").html(response);
        });
    }
	function view_data() {
        $.post('../processing/listthanhtoan.php', { username: '<?php echo $username; ?>' }, function(data) {
            $("#listcart").html(data);
        });
    }
	function show_info_ship_order() {
        $.post('../processing/updateinfoship.php', function(response) {
            $("#info").html(response);
            if(response=="Vui lòng chọn địa chỉ nhận hàng"){
                $("#payment-section").css("display", "none");
            }else{
                $("#payment-section").css("display", "block");
            }        
        });
    }
    $(document).ready(function() {
		$('input[id="newphone"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        });   
        $('input[id="newname"]').on('input', function() {
        this.value = this.value.replace(/[0-9]/g, '');
        });
        show_info_ship_model();
		show_info_ship_order()
		view_data();
		//thêm mới địa chỉ
		$(document).on('click', '.addNewAddressBtn', function() {
			var name = $('#newname').val();
			var phone = $('#newphone').val();
			var address = $('#newaddress').val();
			$.ajax({
				url: '../Processing/newinfo_ship.php',
				type: 'POST',
				data: {
					name: name,
					phone: phone,
					address: address 
				},
				success: function(response) {
					var reponsetemp = "";
					var color = "red";
					if (response == "infotrue") {
						show_info_ship_model();
						$("#newname").val('');
						$("#newphone").val('');
						$("#newaddress").val('');
						reponsetemp="Thêm Mới Địa Chỉ Thành Công"
						color = "linear-gradient(to right, #00b09b, #96c93d)";
					} else if (response == "nullname") {
						reponsetemp="Vui Lòng Nhập Tên"
					}else if (response == "lengthname") {
						reponsetemp="Tên Quá Dài"
					} else if (response == "shortname") {
						reponsetemp="Tên Quá Ngắn"
					}else if (response == "nullphonenumber") {
						reponsetemp="Vui lòng nhập số điện thoại"
					} else if (response == "erphonenumber") {
						reponsetemp="Số điện thoại không hợp lệ"
					}else if (response == "eraddress") {
						reponsetemp="Vui lòng nhập địa chỉ"
					}else if (response == "lengthaddress") {
						reponsetemp="Địa Chỉ Quá Dài"
					}else if (response == "shortaddress") {
						reponsetemp="Địa Chỉ Quá Ngắn"
					}else {
						reponsetemp = response
					}
					Toastify({
						text:  reponsetemp,
						duration: 3000,
						newWindow: true,
						close: true,
						gravity: "top", 
						position: "right", 
						stopOnFocus: true, 
						style: {
							background: color,
						},
						onClick: function () { } 
					}).showToast();
				},
				error: function(xhr, status, error) {
					Toastify({
						text:  "Có lỗi xảy ra, vui lòng thử lại sau!",
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
			});
		});
		//địa chỉ mặc định
		$(document).on('click', '.macdinhinfo', function() {
            var selectedId = $("input[name='address']:checked").data("id");   
            $.ajax({
                url: '../Processing/default_info_user.php',
                type: 'POST',
                data: { selectedId: selectedId },
                success: function(response) {
                    if(response=="OK"){
						show_info_ship_model();
                        Toastify({
                            text:  "Đặt địa chỉ mặc định Thành Công",
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
                }
            });
        });
		$(document).on('click', '.capnhatinfo', function() {
            var selectedId = $("input[name='address']:checked").data("id");
            $.ajax({
                url: '../Processing/updateinfoship.php',
                type: 'POST',
                data: { selectedId: selectedId },
                success: function(response) {
                    $('#info').html(response);
                    Toastify({
                        text:  "Thay Đổi Địa Chỉ Thành Công",
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
                    if(response=="Vui lòng chọn địa chỉ nhận hàng"){
                        $("#payment-section").css("display", "none");

                    }else{
                        $("#payment-section").css("display", "block");
                    }
                    
                }
            });
        });
		paypal.Buttons({
            createOrder: function(data, actions) {
				var exchangeRate = 0.000043; // Giả sử tỷ giá này, bạn cần thay đổi nó theo tỷ giá thực tế

				// Giá tiền ban đầu ở đơn vị VND
				var priceInVND = <?php echo $totalprice; ?>;

				// Chuyển đổi giá tiền sang USD
				var priceInUSD = priceInVND * exchangeRate;
                return actions.order.create({
                    purchase_units: [{
                        amount: {
							currency_code: 'USD',
                            value: priceInUSD.toFixed(2) //Làm tròn giá tiền thành 2 chữ số thập phân
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    var idInfoShip = document.querySelector('#address').dataset.id;
                    var create_at = new Date().toISOString();
                    var requestData = {
                        'id_info_ship': idInfoShip,
                        'createat': create_at,
                        'paymentstatus': 1,
                        'paymentmethod': "PayPal",
                    };
                    $.ajax({
                        method: "POST",
                        url: "../Processing/order.php",
                        data: requestData,
                    })
                    .done(function(response) {
                        $("#payment-section").css("display", "none");
                        $("#btnthaydoi").css("display", "none");
                        var color = "red";
                        if(response==200){
                           color = "linear-gradient(to right, #00b09b, #96c93d)";
                           response = "Bạn Đã Đặt Hàng Thành Công";
                        }
						const totalCartMenu = document.querySelector('.totalcartmenu');
						if (totalCartMenu) {
							totalCartMenu.textContent = '0';
						}
                        Toastify({
                            text: response,
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top", 
                            position: "right", 
                            stopOnFocus: true, 
                            style: {
                                background:color ,
                            },
                            onClick: function () { } // Callback after click
                        }).showToast();
                    });
                });
            }
        }).render('#paypal-button-container');
		 //thanh toán khi nhận hàng 
		 $(document).on('click', '#confirm-payment-btn', function() {
			var idInfoShip = document.querySelector('input[name="address"]:checked').dataset.id;
			var create_at = new Date().toISOString();
			var requestData = {
				'id_info_ship': idInfoShip,
				'createat': create_at,
				'paymentstatus': 0,
				'paymentmethod': "Thanh Toán Khi Nhận Hàng",
			};		
			$.ajax({
				method: "POST",
				url: "../Processing/order.php",
				data: requestData,
			}).done(function(response) {
				$("#thanhtoankhinhanhang, #paypal-button-container, #btnthaydoi").hide();
				Toastify({
					text: "Đặt Hàng Thành Công",
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
				const totalCartMenu = document.querySelector('.totalcartmenu');
				if (totalCartMenu) {
					totalCartMenu.textContent = '0';
				}
				// Close the modal
				var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
				modal.hide();
			});
		});
    });
</script>
<?php
	}
 }
?>