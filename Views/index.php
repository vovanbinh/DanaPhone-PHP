
<?php
require_once "../Views/UserHead.php";
?>
<!-- Start Hero Section -->
	<div class="hero">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-lg-5">
					<div class="intro-excerpt">
						<h1>DANA PHONE</h1>
						<p class="mb-4">Dana Phone Đà Nẵng: Điểm đến hàng đầu cho các sản phẩm điện thoại chất lượng.</p>
						<p><a href="../views/shop.php" class="btn btn-secondary me-2">Shop Now</a>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="hero-img-wrap">
						<img src="../Public/images/iphone14promax256gb.webp" alt="Image" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- End Hero Section -->

<!-- Start Product Section -->
<div class="product-section">
	<div class="container">
		<div class="row mt-5">
			<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
				<h2 class="mb-4 section-title">Chào mừng bạn đến với Dana Phone Đà Nẵng.</h2>
				<p class="mb-4">Điểm đến hàng đầu để khám phá thế giới của điện thoại di động và công nghệ. Chúng tôi tự hào cung cấp một loạt các sản phẩm điện thoại thông minh chất lượng cao và phụ kiện đa dạng, đáp ứng mọi nhu cầu của bạn.</p>
				<p><a href="../Views/shop.php" class="btn">Khám Phá</a></p>
			</div> 
			<?php
				require_once '../Processing/connect.php';
				$sql = "SELECT p.name AS product_name, 
                p.image AS product_image, 
                p.id AS product_id, 
                p.price AS product_price, 
                p.status AS product_status, 
                c.status AS category_status
				FROM product p
				JOIN order_detail od ON p.id = od.product_id
				JOIN `oder` o ON od.oder_id = o.id
				JOIN category c ON p.catalogcode = c.id
				WHERE o.payment_status = 1
				GROUP BY p.id
				ORDER BY SUM(od.product_quantity) DESC
				LIMIT 3";
				$result = mysqli_query($conn, $sql);
				if ($result && mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
							$status = $row['product_status'];
							$image = $row['product_image'];
							$name = $row['product_name'];
							$price = $row['product_price'];
							$formattedPrice = number_format($price, 0, '.', '.').' VND';
							$id = $row['product_id'];
							$category_status = $row['category_status'];
							if($status ==0 and $category_status ==0){
						?>
						<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
							<a class="product-item" href="../Views/Detail_Product.php?id=<?php echo $id;?>">
								<img src="../Public/images/<?php echo $image;?>" alt="Image"class="img-fluid product-thumbnail">
								<h3 class="product-title"><?php echo $name;?></h3>
								<strong class="product-price"><?php echo $formattedPrice;?></strong>
							</a>
						</div>
						<?php
						}
					}
				} else {
					echo 'Không có sản phẩm nào được tìm thấy.';
				}
				?>
		</div>
	</div>
</div>
<div class="why-choose-section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-6">
				<h2 class="section-title">Tại Sao Bạn Nên Chọn Chúng Tôi</h2>
				<p>Dana Phone cung cấp một loạt các sản phẩm và dịch vụ liên quan đến điện thoại di động, từ các dòng sản phẩm mới nhất cho đến các sản phẩm giá rẻ, đáp ứng nhu cầu đa dạng của khách hàng.</p>

				<div class="row my-5">
					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="../Public/images/truck.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Giao hàng nhanh chóng &amp; miễn phí</h3>
							<p>Không cần chờ đợi! Dana Phone mang đến dịch vụ giao hàng nhanh chóng và hoàn toàn miễn phí, giúp bạn nhận được sản phẩm mơ ước trong thời gian ngắn nhất.</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="../Public/images/bag.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Dễ dàng mua sắm</h3>
							<p>Trải nghiệm mua sắm đơn giản và thuận tiện tại Dana Phone. Chỉ cần vài bước, bạn đã sở hữu sản phẩm mong muốn!</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="../Public/images/support.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Hỗ trợ 24/7</h3>
							<p>Chúng tôi luôn đồng hành cùng bạn, bất kể thời gian nào trong ngày. Với dịch vụ hỗ trợ 24/7 của chúng tôi, bạn sẽ luôn được chăm sóc tận tâm.</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="../Public/images/return.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Trả hàng dễ dàng</h3>
							<p>Không hài lòng? Đừng lo, chúng tôi đảm bảo quyền lợi của bạn với dịch vụ trả hàng dễ dàng và thuận tiện.</p>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-5">
				<div class="img-wrap">
					<img src="../Public/images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
				</div>
			</div>

		</div>
	</div>
</div>
<div class="testimonial-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="testimonial-slider-wrap text-center">
					<div class="testimonial-slider">
						<div class="item">
							<div class="row justify-content-center">
								<div class="col-lg-8 mx-auto">
									<div class="testimonial-block text-center">
										<blockquote class="mb-5">
											<p>&ldquo;Tôi đã khởi đầu dự án này với mục tiêu mang đến sự khác biệt đối với thị trường điện thoại di động. Sự đam mê về công nghệ và sự cam kết với chất lượng đã thúc đẩy tôi tạo ra một nền tảng mua sắm trực tuyến đáng tin cậy, thuận tiện và thú vị cho khách hàng.&rdquo;</p>
										</blockquote>
										<div class="author-info">
											<div class="author-pic">
												<img src="../Public/images/admin.jpg" alt="Vo Van Binh" class="img-fluid">
											</div>
											<h3 class="font-weight-bold">Vo Van Binh</h3>
											<span class="position d-block mb-3">CEO, Co-Founder, DANA PHONE.</span>
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