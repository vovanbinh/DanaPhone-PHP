<?php
require_once '../Processing/connect.php';
$isFormSubmitted = false;
session_start();
if (isset($_POST['submit'])) {
    $isFormSubmitted = true;
    $datetimePicker1 = $_POST['datetimePicker1'];
    $datetimePicker2 = $_POST['datetimePicker2'];
}
if ($isFormSubmitted) {
    $sql = "SELECT c.name AS category_name, SUM(p.price*od.product_quantity) AS total_sales
            FROM category c
            JOIN product p ON c.id = p.catalogcode
            JOIN order_detail od ON p.id = od.product_id
            JOIN oder o ON od.oder_id = o.id
            WHERE o.create_at >= '$datetimePicker1' AND o.create_at <= '$datetimePicker2' AND o.payment_status =1
            GROUP BY c.name";
} else {
    // Trường hợp mặc định, hiển thị tất cả thời gian
    $sql = "SELECT c.name AS category_name, SUM(p.price*od.product_quantity) AS total_sales
            FROM category c
            JOIN product p ON c.id = p.catalogcode
            JOIN order_detail od ON p.id = od.product_id
            JOIN oder o ON od.oder_id = o.id
            WHERE o.payment_status =1
            GROUP BY c.name";
}
$result = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_array($result)){
    $data[] = $row;
}
$chartData = [['Task', 'Total Sales']];
foreach ($data as $row) {
    $chartData[] = [$row['category_name'], (int)$row['total_sales']];
}
$chartDataJson = json_encode($chartData);
?>

<!doctype html>
<html lang="en">

<head>
   <?php
    require_once '../Views/Admin_head.php';
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
                            <i class="pe-7s-glasses fa fa-chart-pie "></i>
                        </div>
                        <div>Thống Kê Doanh Số Bán Hàng Theo Danh Mục<div class="page-title-subheading">Bạn có thể chọn thời gian bắt đầu và kết thúc nếu muốn thống kê theo mốc thời gian!</div>
                        </div>
                        </div>
                    </div>
                    </div>
                <div class="main-card mb-3 col-lg-7 card" style="min-width:600px;">
                     <div class="row mt-3" style="min-width:600px;">
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-5">
                                    <input style="max-width:300px;" type="datetime-local" name="datetimePicker1" class="form-control">
                                </div>
                                <div class="col-md-1 mt-2">
                                    <strong>To</strong>
                                </div>
                                <div class="col-md-5">
                                    <input style="max-width:300px;" type="datetime-local" name="datetimePicker2" class="form-control">
                                </div>
                                <div class="col-md-3 mt-3">
                                    <button type="submit" name="submit" class="mb-2 mr-2 btn btn-success">Thống Kê</button>
                                </div>
                            </div>
                        </form>
                     </div>
                    <div id="piechart_3d" style="height:400px; width:580px;"></div>
                </div>
        <?php
            require_once '../Views/Admin_footer.php';
        ?>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Total Sales');
        var phpData = <?php echo json_encode($data); ?>;
        var total = 0;

        for (var i = 0; i < phpData.length; i++) {
            var categorySales = parseFloat(phpData[i].total_sales); // Chuyển đổi thành số thập phân
            data.addRow([phpData[i].category_name, categorySales]);
            total += categorySales;
        }

        var formattedTotal = total.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });

        var options = {
            title: 'Thống Kê Doanh Số Bán Được Theo Danh Mục\nTổng Doanh Thu: ' + formattedTotal,
            pieHole: 0.4,
        };

        var datetimePicker1 = "<?php echo isset($datetimePicker1) ? $datetimePicker1 : ''; ?>";
        var datetimePicker2 = "<?php echo isset($datetimePicker2) ? $datetimePicker2 : ''; ?>";

        if (datetimePicker1 && datetimePicker2) {
            options.title += ' (' + datetimePicker1 + ' - ' + datetimePicker2 + ')';
        }

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>
</html>
