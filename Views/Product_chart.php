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
    $sql = "SELECT p.name AS product_name, SUM(od.product_quantity) AS total_quantity_sold
    FROM product p
    JOIN order_detail od ON p.id = od.product_id
    JOIN `oder` o ON od.oder_id = o.id
    WHERE o.create_at >= '$datetimePicker1' AND o.create_at <= '$datetimePicker2' AND o.payment_status = 1
    GROUP BY p.name
    ORDER BY total_quantity_sold DESC";
} else {
    // Trường hợp mặc định, hiển thị tất cả thời gian
    $sql = "SELECT p.name AS product_name, SUM(od.product_quantity) AS total_quantity_sold
    FROM product p
    JOIN order_detail od ON p.id = od.product_id
    JOIN `oder` o ON od.oder_id = o.id
    WHERE o.payment_status = 1
    GROUP BY p.name
    ORDER BY total_quantity_sold DESC";
}
$result = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_array($result)){
    $data[] = $row;
}
$chartData = [['Task', 'Total Sales']];
foreach ($data as $row) {
    $chartData[] = [$row['product_name'], (int)$row['total_quantity_sold']];
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
                <div class="main-card mb-3 col-12 card" style="min-width:1000px;">
                     <div class="row col-8 mt-3" >
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
                     <div id="top_x_div" class="ml-2" style="width: 900px; height: 500px;"></div>
                </div>
        <?php
            require_once '../Views/Admin_footer.php';
        ?>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var jsonData = <?php echo json_encode($data); ?>;
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Tên Sản Phẩm');
        data.addColumn('number', 'Tổng số lượng bán');

        var total = 0;
        for (var i = 0; i < jsonData.length; i++) {
            var product_sales = parseInt(jsonData[i].total_quantity_sold);
            data.addRow([jsonData[i].product_name, product_sales]);
            total += product_sales;
        }

        var options = {
          title: 'Thống Kê Số Lượng Sản Phẩm Bán Được',
          width: 900,
          legend: { position: 'none' },
          chart: { title: 'Thống Kê Số Lượng Sản Phẩm Bán Được <?php if(isset($datetimePicker1) && isset($datetimePicker2)) echo 'từ ' .$datetimePicker1 . ' đến ' . $datetimePicker2; ?>',
                   subtitle: 'Tổng số lượng đã bán: '+total },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Biểu đồ thống kê'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };
        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
</html>
