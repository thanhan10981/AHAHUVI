<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index_ad.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Bảng điều khiển</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="filter-section">
                <h2>BẢNG ĐIỀU KHIỂN</h2>
                <div class="filters">
                    <div class="filter-item">
                        <label>Số lượng sách</label>
                        <?php
                        require("../Home/connect.php");
                        $sql = "SELECT COUNT(id_sp) AS total_sp FROM san_pham";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo ' <input type="text" readonly value='  . $row['total_sp'] . '>';
                        }
                        ?>
                    </div>
                    <div class="filter-item">
                        <label>Số lượng đơn hàng</label>

                        <?php
                        require("../Home/connect.php");
                        $sql1 = "SELECT COUNT(id_don_hang) AS total_orders FROM don_hang";
                        $result1 = $conn->query($sql1);
                        if ($result1->num_rows > 0) {
                            $row1 = $result1->fetch_assoc();
                            echo ' <input type="text" readonly value='  . $row1['total_orders'] . '>';
                        }
                        ?>
                    </div>
                    <div class="filter-item">
                        <label> Doanh thu</label>
                        <?php
                        require("../Home/connect.php");
                        $sql = "SELECT SUM(tong_tien) AS total_revenue 
                        FROM don_hang 
                        WHERE MONTH(ngay_tao) = MONTH(CURDATE()) AND YEAR(ngay_tao) = YEAR(CURDATE())";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            echo '<input type="text" readonly value="Tháng Này: ' . number_format($row['total_revenue'], 0, ',', '.') . ' VNĐ">';
                        } else {
                            echo '<input type="text" readonly value="Không có dữ liệu">';
                        }
                        ?>
                    </div>
                    <div class="filter-item">
                        <label>Số lượng khách hàng</label>
                        <?php
                        require("../Home/connect.php");
                        $sql2 = "SELECT COUNT(mkh) AS total_mkh FROM khach_hang";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            echo ' <input type="text" readonly value='  . $row2['total_mkh'] . '>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="report-section">
                <div class="chart">
                    <h3> Doanh thu theo tháng</h3>
                    <div id="chart_div" style="width: 500px; height: 400px;"></div>
                </div>
                <div class="list bestseller">
                    <h3><i class="fa-solid fa-book"></i> Sách bán chạy</h3>
                    <ul>
                        <?php
                        require('../Home/connect.php');
                        $sql_sp = " SELECT sp.id_sp, sp.ten_sp, sp.gia, sp.anh_bia, SUM(spdm.sl) AS total_sold
                        FROM san_pham_dat_mua AS spdm
                        JOIN san_pham AS sp ON spdm.id_sp = sp.id_sp
                        GROUP BY sp.id_sp
                        ORDER BY total_sold DESC
                        LIMIT 10 ";

                        $result = mysqli_query($conn, $sql_sp);
                        $ii = 1;
                        while ($row4 = mysqli_fetch_assoc($result)) {
                            echo '<li>' . $ii . '. ' . $row4['ten_sp'] . '</li>';
                            $ii++;
                        } ?>
                    </ul>
                </div>
                <div class="list low-inventory">
                    <h3><i class="fa-solid fa-truck-ramp-box"></i> Sách tồn kho thấp</h3>
                    <ul>
                        <?php
                        require('../Home/connect.php');
                        $sql_sp = " SELECT san_pham.ten_sp 
                                    FROM san_pham 
                                    JOIN kho ON san_pham.id_sp = kho.id_sp 
                                    WHERE kho.sl < 10";

                        $result = mysqli_query($conn, $sql_sp);
                        $ii = 1;
                        while ($row4 = mysqli_fetch_assoc($result)) {
                            echo '<li>' . $ii . '. ' . $row4['ten_sp'] . '</li>';
                            $ii++;
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tháng', 'Doanh thu'],
                <?php
                require("../Home/connect.php");
                $sql = "SELECT MONTH(ngay_tao) AS month, SUM(tong_tien) AS total_revenue 
                    FROM don_hang 
                    GROUP BY MONTH(ngay_tao)";
                $result = $conn->query($sql);


                $data = [];
                while ($row = $result->fetch_assoc()) {
                  
                    $formatted_revenue = number_format($row['total_revenue'], 0, 0, 0);
                    $data[] = [$row['month'], $formatted_revenue];
                }
                
                // Hiển thị dữ liệu
                foreach ($data as $d) {
                    echo "['Tháng " . $d[0] . "', " . $d[1] . "],";
                }
                
                ?>
            ]);
            var options = {
                chart: {
                    title: 'Doanh Thu Hàng Tháng',
                    subtitle: 'Đơn vị: VNĐ'
                },
                bars: 'vertical',
                vAxis: {
                    format: '#,####'
                },
                height: 400,
                colors: ['#1b9e77']
            };
            var chart = new google.charts.Bar(document.getElementById('chart_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
</body>

</html>