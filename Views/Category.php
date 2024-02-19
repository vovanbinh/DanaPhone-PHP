<?php
require_once "../Views/UserHead.php";
require_once '../Processing/connect.php';
$minPrice = 0;
$maxPrice = PHP_INT_MAX;
if (isset($_GET["idcategory"])) {
    $idcategory = $_GET["idcategory"];
}
if (isset($_GET["price-range"])) {
    $pricerange = $_GET["price-range"];
    if ($pricerange === '30000000') {
        $minPrice = 30000000;
    } else {
        list($minPrice, $maxPrice) = explode('-', $pricerange);

        if (!is_numeric($minPrice) || !is_numeric($maxPrice)) {
            echo "Lỗi";
        }
    }
}
$productsPerPage = 6;


$sqlCount = "SELECT COUNT(*) AS total 
FROM product WHERE catalogcode = '$idcategory' 
AND price >= '$minPrice' AND price <= '$maxPrice' AND status =0";
$resultCount = mysqli_query($conn, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalProducts = $rowCount['total'];
$totalPages = ceil($totalProducts / $productsPerPage);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($current_page - 1) * $productsPerPage;
$sql = "SELECT *
        FROM product 
        WHERE catalogcode = '$idcategory' 
        AND price >= '$minPrice'
        AND price <= '$maxPrice'
        LIMIT $start, $productsPerPage";
$result = mysqli_query($conn, $sql);
?>
<div class="hero-depqua mb-5">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-excerpt">
                <?php
                if (isset($_GET["idcategory"])) {
                    $idcategory = $_GET["idcategory"];
                    require_once '../Processing/connect.php';
                    $sql = "SELECT name FROM category WHERE id = $idcategory";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
                            $name = $row['name'];
                        } else {
                            $name = "Không Tồn Tại";
                        }
                    } else {
                        $name = "Không Tồn Tại";
                    }
                } else {
                    $name = "Không Tồn Tại";
                }
                ?>
                <h3>Danh Mục Sản Phẩm <?php echo $name; ?></h3>
                <p class="mb-4">Dana Phone Đà Nẵng: Điểm đến hàng đầu cho các sản phẩm điện thoại chất lượng.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="untree_co-section product-section before-footer-section">
    <div class="row ml-4 mr-4" style="min-height: 600px;">
         <div class="col-md-2">
            <div>
                <div class="form-group">
                    <h3 style="color:#3b5d50;">Khoảng giá:</h3>
                    <div class="form-check">
                        <a class="form-check-label" style="color:#3b5d50;"
                            href="../Views/category.php?idcategory=<?php echo $idcategory; ?>&price-range=10000000-20000000">
                            10 Triệu - 20 Triệu
                        </a>
                    </div>
                    <div class="form-check">
                        <a class="form-check-label" style="color:#3b5d50;"
                            href="../Views/category.php?idcategory=<?php echo $idcategory; ?>&price-range=20000000-30000000">
                            20 Triệu - 30 Triệu
                        </a>
                    </div>
                    <div class="form-check">
                        <a class="form-check-label" style="color:#3b5d50;"
                            href="../Views/category.php?idcategory=<?php echo $idcategory; ?>&price-range=30000000">
                            Trên 30 Triệu
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10">
        <?php
            if (isset($_GET["price-range"])) {
                $pricerange = $_GET["price-range"];
                $priceParts = explode("-", $pricerange);
                if (count($priceParts) == 1) {
                    $minPrice = (int) $priceParts[0];
                    $formattedMinPrice = number_format($minPrice, 0, ',', '.');
                    ?>
                    <p class="text-danger">Khoảng Giá Từ
                        <?php echo $formattedMinPrice . ' VND trở lên'; ?>
                    </p>
                    <?php
                }
                if (count($priceParts) == 2) {
                    $minPrice = (int) $priceParts[0];
                    $maxPrice = (int) $priceParts[1];
                    $formattedMinPrice = number_format($minPrice, 0, ',', '.');
                    $formattedMaxPrice = number_format($maxPrice, 0, ',', '.');
                    ?>
                    <p class="text-danger">Khoảng Giá Từ
                        <?php echo $formattedMinPrice . ' VND' . ' - ' . $formattedMaxPrice . ' VND'; ?>
                    </p>
                    <?php
                }
            }
            ?>
            <div class="row">
                <?php
                $sql = "SELECT *
                        FROM product 
                        WHERE catalogcode = '$idcategory' 
                        AND price >= '$minPrice'
                        AND price <= '$maxPrice'
                        LIMIT $start, $productsPerPage";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status = $row['status'];
                        $image = $row['image'];
                        $name = $row['name'];
                        $price = $row['price'];
                        $formattedPrice = number_format($price, 0, '.', '.').' VND';
                        $id = $row['id'];
                        if ($status == 0) {
                            ?>
                            <div class="col-12 col-md-4 col-lg-2 mb-5 ">
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
              <div class="mt-2">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                            if ($totalPages > 1) {
                                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                if ($currentPage > 1) {
                                    $prevPageLink = "../Views/category.php?idcategory=$idcategory&page=" . ($currentPage - 1);
                                    if (isset($pricerange)) {
                                        $prevPageLink .= "&price-range=$pricerange";
                                    }
                                    echo "<li class='page-item'><a class='page-link' href='$prevPageLink' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                                }
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    $pageLink = "../Views/category.php?idcategory=$idcategory&page=$i";
                                    if (isset($pricerange)) {
                                        $pageLink .= "&price-range=$pricerange";
                                    }
                                    if ($i === $currentPage) {
                                        echo "<li class='page-item active'><a class='page-link' href='$pageLink'>$i</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='$pageLink'>$i</a></li>";
                                    }
                                }
                                if ($currentPage < $totalPages) {
                                    $nextPageLink = "../Views/category.php?idcategory=$idcategory&page=" . ($currentPage + 1);
                                    if (isset($pricerange)) {
                                        $nextPageLink .= "&price-range=$pricerange";
                                    }
                                    echo "<li class='page-item'><a class='page-link' href='$nextPageLink' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../Views/UserFootter.php';
?>
<script>
    $(document).ready(function () {
        $("#search-btn").click(function(event) {
            var searchValue = $("#search-input").val();
            if (searchValue.trim() === "") {
                event.preventDefault(); 
            } else {
                var searchUrl = "../Views/Search.php?search=" + encodeURIComponent(searchValue);
                window.location.href = searchUrl;
            }
        });
    });
</script>