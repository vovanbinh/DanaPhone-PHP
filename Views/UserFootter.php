<!-- Start Footer Section -->
<footer class="footer-section p-0">
	<div class="container relative">
		<div class="row g-5 ">
			<div class="col-lg-5 ">
				<div class="mb-3 footer-logo-wrap"><a href="#" class="footer-logo">DANA PHONE<span>.</span></a></div>
				<p class="mb-3">Tại Dana Phone, chúng tôi luôn đặt khách hàng lên hàng đầu. Tôi tự hào về đội ngũ nhân
					viên và đối tác mà chúng tôi đã xây dựng, với tâm huyết và kiến thức chuyên sâu về ngành công nghệ
					và điện thoại di động.</p>
			</div>
			<div class="col-lg-6 mt-0 ">
				<div class="row links-wrap">
					<div class="col-5 col-sm-6 col-md-3">
						<ul class="list-unstyled">
							<li><a href="#"><strong>Danh Mục</strong></a></li>
							<li><a href="/DANAPHONE/Views/Category.php?idcategory=1">Iphone</a></li>
							<li><a href="/DANAPHONE/Views/Category.php?idcategory=2">SamSung</a></li>
							<li><a href="/DANAPHONE/Views/Category.php?idcategory=27">Oppo</a></li>
							<li><a href="/DANAPHONE/Views/Category.php?idcategory=40">Xiaomi</a></li>
						</ul>
					</div>
					<div class="col-6 col-sm-6 col-md-3">
						<ul class="list-unstyled">
							<li><a href="/DANAPHONE/Views/index.php">Trang Chủ</a></li>
							<?php
							if (isset($_SESSION["username"])) {
								echo '<li><a href="/DANAPHONE/views/Editprofile.php">Tài Khoản Cá Nhân</a></li>';
							} else {
								echo '<li><a href="/DANAPHONE/Views/Login_And_Register.php">Tài Khoản</a></li>';
							}
							?>
							<li><a href="/DANAPHONE/views/shop.php">Cửa Hàng</a></li>
						</ul>
					</div>
					<div class="col-6 col-sm-6 col-md-3">
						<ul class="list-unstyled">
							<?php
							if (isset($_SESSION["username"])) {
								echo '<li><a href="/DANAPHONE/views/Cart.php">Giỏ Hàng</a></li>';
								echo '<li><a href="/DANAPHONE/views/User_list_Order.php">Đơn Hàng</a></li>';
							} else {
								echo '<li><a href="/DANAPHONE/Views/Login_And_Register.php">Giỏ Hàng</a></li>';
								echo '<li><a href="/DANAPHONE/Views/Login_And_Register.php">Đơn Hàng</a></li>';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- End Footer Section -->
<!-- <script type="text/javascript" src="../Public/assets/scripts/main.js"></script> -->
<script src="../Public/js/bootstrap.bundle.min.js"></script>
<!-- <script src="../Public/js/tiny-slider.js"></script> -->
<!-- <script src="../Public/js/custom.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
	integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../Public/js/cdn.jsdelivr.net_npm_toastify-js"></script>
<script
	src="https://www.paypal.com/sdk/js?client-id=AdYtyxx-64JArb3GRdY6Eg6YbdjHOPM1LjBGa0l3mggsvsJM4WnLA8afBImil0qpnEQOLU4vjiZIB3W5&currency=USD"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
<script>
	$("#search-btn").click(function (event) {
		var searchValue = $("#search-input").val();
		if (searchValue.trim() === "") {
			event.preventDefault(); // Ngăn chặn thực hiện tải trang
			Toastify({
				text: "Vui lòng nhập thông tin tìm kiếm",
				duration: 3000,
				newWindow: true,
				close: true,
				gravity: "top",
				position: "right",
				stopOnFocus: true,
				style: {
					background: "red",
				},
				onClick: function () { } // Callback after click
			}).showToast();
		} else {
			var searchUrl = "../Views/Search.php?search=" + encodeURIComponent(searchValue);
			window.location.href = searchUrl;
		}
	});
</script>

</html>