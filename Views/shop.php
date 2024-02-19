<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';

$items_per_page = 12;

// Lấy số trang từ tham số URL hoặc sử dụng giá trị mặc định là 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

$sql_count = "SELECT COUNT(*) as total FROM product p
              INNER JOIN category c ON p.catalogcode = c.id
              WHERE p.status = 0 
              AND c.status = 0";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_items = $row_count['total'];
$total_pages = ceil($total_items / $items_per_page);

// Đảm bảo trang hiện tại không vượt quá tổng số trang
$page = min(max(1, $page), $total_pages);

$offset = ($page - 1) * $items_per_page;
?>
		<div class="hero-depqua mb-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="intro-excerpt">
						<h3>Cùng Thỏa Sức Mua Sắm Tại DANA Bạn Nhé</h3>
						<p class="mb-4">Dana Phone Đà Nẵng: Điểm đến hàng đầu cho các sản phẩm điện thoại chất lượng.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="margin-bottom: 100px;" class=" untree_co-section product-section before-footer-section">
		    <div class="container">
				<div class="row">
					<?php		
						$sql = "SELECT p.*, c.status as catelogystatus
						FROM product p
						INNER JOIN category c ON p.catalogcode = c.id
						WHERE p.status = 0 
						AND c.status = 0
						LIMIT $offset, $items_per_page";
						$result = mysqli_query($conn, $sql);
						if ($result && mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								$status = $row['status'];
								$image = $row['image'];
								$name = $row['name'];
								$price = $row['price'];
								$formattedPrice = number_format($price, 0, '.', '.').' VND';
								$id = $row['id'];
								$category_status = $row['catelogystatus'];
								if($status ==0 and $category_status ==0){
					?>
						<div class="col-12 col-md-4 col-lg-2 mb-5">
							<a class="product-item" href="../Views/Detail_product.php?id=<?php echo $id; ?>">
								<img src="../Public/images/<?php echo $image; ?>" alt="Image" class="img-fluid product-thumbnail">
								<h3 class="product-title"><?php echo $name; ?></h3>
								<strong class="product-price"><?php echo $formattedPrice; ?></strong>
							</a>
						</div>
					<?php
								}
							}
						} else {
							echo '<p class="h3">Không có sản phẩm trong danh mục này.</p>';
						}
					?>
				</div>
				<?php  if ($total_pages > 1) {?>
				<nav aria-label="Page navigation">
					<ul class="pagination justify-content-center">
						<li class="page-item <?php if ($page === 1) echo 'disabled'; ?>">
						<a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1" aria-disabled="true">Previous</a>
						</li>
						<?php for ($i = 1; $i <= $total_pages; $i++) : ?>
						<li class="page-item <?php if ($i === $page) echo 'active'; ?>">
							<a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
						</li>
						<?php endfor; ?>
						<li class="page-item <?php if ($page === $total_pages) echo 'disabled'; ?>">
						<a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
						</li>
					</ul>
				</nav>
				<?php
				}
				?>
		    </div>
		</div>
		 
<?php
require_once "../Views/UserFootter.php";
?>