<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';

$searchValue = $_GET['search'];
$escapedSearchValue = $conn->real_escape_string($searchValue);

$sql = "SELECT p.*, c.name as namecategory
        FROM product p
        INNER JOIN category c ON p.catalogcode = c.id
        WHERE p.name LIKE '%$escapedSearchValue%' OR c.name LIKE '%$escapedSearchValue%'";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0):
?>
    <div class="hero-depqua mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-excerpt">
                    <h3>Tìm Kiếm Sản Phẩm</h3>
                    <p class="mb-4">Dana Phone Đà Nẵng: Điểm đến hàng đầu cho các sản phẩm điện thoại chất lượng.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container untree_co-section product-section before-footer-section mt-5"  style="min-height:600px;">
        <div class="row">
        <?php
        while ($row = mysqli_fetch_assoc($result)):
            $status = $row['status'];
            $image = $row['image'];
            $name = $row['name'];
            $price = $row['price'];
            $formattedPrice = number_format($price, 2, '.', ',');
            $id = $row['id'];

            if ($status == 0):
        ?>
            <div class="col-12 col-md-4 col-lg-2 mb-5">
                <a class="product-item" href="../Views/Detail_product.php?id=<?php echo $id; ?>">
                    <img src="../Public/images/<?php echo $image; ?>" alt="Image" class="img-fluid product-thumbnail">
                    <h3 class="product-title"><?php echo $name; ?></h3>
                    <strong class="product-price">$ <?php echo $formattedPrice; ?></strong>
                </a>
            </div>
        <?php
            endif;
        endwhile;
        ?>
        </div>
    </div>
<?php
else:
    echo '<p style="min-height:700px;" class="h3 ml-3 text-center mt-3 text-danger">Không có sản phẩm trong danh mục này.</p>';
endif;

require_once "../Views/UserFootter.php";
?>
