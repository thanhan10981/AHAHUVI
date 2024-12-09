<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bao_cao_doanh_thu.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Báo cáo doanh thu</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>BÁO CÁO DOANH THU</p>
            </div>
            <div class="headerbc">
            </div>

            <div class="summary">
                <div class="summary-item">
                    <p>Tổng Doanh Thu</p>
                    <?php
                    require("../Home/connect.php");
                    $sql = "SELECT SUM(tong_tien) AS total_revenue FROM don_hang";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<h2>' . number_format($row['total_revenue'], 0, ',', ',') . 'đ</h2>';
                    }
                    ?>
                </div>
                <div class="summary-item">
                    <p>Doanh Thu Tháng Hiện Tại</p>
                    <?php
                    require("../Home/connect.php");
                    $sql = "SELECT SUM(tong_tien) AS total_revenue 
                        FROM don_hang 
                        WHERE MONTH(ngay_tao) = MONTH(CURDATE()) AND YEAR(ngay_tao) = YEAR(CURDATE())";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<h2>' . number_format($row['total_revenue'], 0, ',', ',') . 'đ</h2>';
                    }
                    ?>
                </div>

                <div class="summary-item">
                    <p>Tổng Đơn Hàng</p>
                    <?php
                    require("../Home/connect.php");
                    $sql1 = "SELECT COUNT(id_don_hang) AS total_orders FROM don_hang";
                    $result1 = $conn->query($sql1);
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        echo '<h2>'  . $row1['total_orders'] . '</h2>';
                    }
                    ?>
                </div>
                <div class="summary-item">
                    <p>Đơn Hàng Tháng Hiện Tại</p>
                    <?php
                    require("../Home/connect.php");
                    $currentMonth = date('m');
                    $currentYear = date('Y');
                    $sql1 = "SELECT COUNT(id_don_hang) AS total_orders_current_month 
                    FROM don_hang 
                    WHERE MONTH(ngay_tao) = $currentMonth AND YEAR(ngay_tao) = $currentYear";
                    $result1 = $conn->query($sql1);
                    if ($result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        echo '<h2>' . $row1['total_orders_current_month'] . '</h2>';
                    } else {
                        echo '<h2>0</h2>';
                    }
                    ?>

                </div>
            </div>
            <div class="group-charts">
                <div class="chart">
                    <h3>Doanh Thu Theo Tháng</h3>
                    <div id="chart-div-3"></div>
                </div>
            </div>
            <div class="charts">
                <div class="chart">
                    <h3>Doanh Thu Theo Nhóm Danh Mục SP</h3>
                    <div id="chart-div-1"></div>
                </div>
                <div class="chart">
                    <h3>Tăng Trưởng Doanh Thu Từng Nhóm Thể Loại</h3>
                    <div id="chart-div-2"></div>
                </div>
            </div>
            
        </div>
    </div>
</body>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load("upcoming", {
        packages: ["vegachart"]
    }).then(drawChart)
    <?php
    require("../Home/connect.php");
    
    $sql = "
    SELECT 
        dm.ten_danh_muc AS category,
        SUM(dh.tong_tien) AS total_revenue
    FROM 
        don_hang dh
    INNER JOIN 
        san_pham_dat_mua spdm ON dh.id_don_hang = spdm.id_don_hang
    INNER JOIN 
        san_pham sp ON spdm.id_sp = sp.id_sp
    INNER JOIN 
        danh_muc dm ON sp.id_danh_muc = dm.id_danh_muc
    GROUP BY 
        dm.id_danh_muc
    ORDER BY 
        total_revenue DESC;
    ";
    
    $result = $conn->query($sql);
    
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [$row["category"], (float)$row["total_revenue"]];
        }
    }
    
    

    ?>

    function drawChart() {
        const dataTable = new google.visualization.DataTable()
        dataTable.addColumn({
            type: "string",
            id: "category"
        })
        dataTable.addColumn({
            type: "number",
            id: "amount"
        })
        dataTable.addRows(<?php echo json_encode($data) ?>)
       



        const options = {
            vega: {
                $schema: "https://vega.github.io/schema/vega/v4.json",
                width: 500,
                height: 200,
                padding: 5,

                data: [{
                    name: "table",
                    source: "datatable"
                }],

                signals: [{
                    name: "tooltip",
                    value: {},
                    on: [{
                            events: "rect:mouseover",
                            update: "datum"
                        },
                        {
                            events: "rect:mouseout",
                            update: "{}"
                        },
                    ],
                }, ],

                scales: [{
                        name: "xscale",
                        type: "band",
                        domain: {
                            data: "table",
                            field: "category"
                        },
                        range: "width",
                        padding: 0.05,
                        round: true,
                    },
                    {
                        name: "yscale",
                        domain: {
                            data: "table",
                            field: "amount"
                        },
                        nice: true,
                        range: "height",
                    },
                ],

                axes: [{
                        orient: "bottom",
                        scale: "xscale"
                    },
                    {
                        orient: "left",
                        scale: "yscale"
                    },
                ],

                marks: [{
                        type: "rect",
                        from: {
                            data: "table"
                        },
                        encode: {
                            enter: {
                                x: {
                                    scale: "xscale",
                                    field: "category"
                                },
                                width: {
                                    scale: "xscale",
                                    band: 1
                                },
                                y: {
                                    scale: "yscale",
                                    field: "amount"
                                },
                                y2: {
                                    scale: "yscale",
                                    value: 0
                                },
                            },
                            update: {
                                fill: {
                                    value: "steelblue"
                                },
                            },
                            hover: {
                                fill: {
                                    value: "red"
                                },
                            },
                        },
                    },
                    {
                        type: "text",
                        encode: {
                            enter: {
                                align: {
                                    value: "center"
                                },
                                baseline: {
                                    value: "bottom"
                                },
                                fill: {
                                    value: "#333"
                                },
                            },
                            update: {
                                x: {
                                    scale: "xscale",
                                    signal: "tooltip.category",
                                    band: 0.5
                                },
                                y: {
                                    scale: "yscale",
                                    signal: "tooltip.amount",
                                    offset: -2
                                },
                                text: {
                                    signal: "tooltip.amount"
                                },
                                fillOpacity: [{
                                        test: "datum === tooltip",
                                        value: 0
                                    },
                                    {
                                        value: 1
                                    },
                                ],
                            },
                        },
                    },
                ],
            },
        }

        const chart = new google.visualization.VegaChart(
            document.getElementById("chart-div-1"),
        )
        chart.draw(dataTable, options)
    }
</script>
<script>
    google.charts.load("upcoming", {
        packages: ["vegachart"]
    }).then(drawChart)
    <?php
require("../Home/connect.php");

$sql = "
SELECT 
    tl.ten_the_loai AS category,
    SUM(dh.tong_tien) AS total_revenue
FROM 
    don_hang dh
INNER JOIN 
    san_pham_dat_mua spdm ON dh.id_don_hang = spdm.id_don_hang
INNER JOIN 
    san_pham sp ON spdm.id_sp = sp.id_sp
INNER JOIN 
    the_loai tl ON sp.id_the_loai = tl.id_the_loai
GROUP BY 
    tl.id_the_loai
ORDER BY 
    total_revenue DESC;
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row["category"], (float)$row["total_revenue"]];
    }
}
?>



    function drawChart() {
        const dataTable = new google.visualization.DataTable()
        dataTable.addColumn({
            type: "string",
            id: "category"
        })
        dataTable.addColumn({
            type: "number",
            id: "amount"
        })
        dataTable.addRows(<?php echo json_encode($data) ?>)



        const options = {
            vega: {
                $schema: "https://vega.github.io/schema/vega/v4.json",
                width: 500,
                height: 200,
                padding: 5,

                data: [{
                    name: "table",
                    source: "datatable"
                }],

                signals: [{
                    name: "tooltip",
                    value: {},
                    on: [{
                            events: "rect:mouseover",
                            update: "datum"
                        },
                        {
                            events: "rect:mouseout",
                            update: "{}"
                        },
                    ],
                }, ],

                scales: [{
                        name: "xscale",
                        type: "band",
                        domain: {
                            data: "table",
                            field: "category"
                        },
                        range: "width",
                        padding: 0.05,
                        round: true,
                    },
                    {
                        name: "yscale",
                        domain: {
                            data: "table",
                            field: "amount"
                        },
                        nice: true,
                        range: "height",
                    },
                ],

                axes: [{
                        orient: "bottom",
                        scale: "xscale"
                    },
                    {
                        orient: "left",
                        scale: "yscale"
                    },
                ],

                marks: [{
                        type: "rect",
                        from: {
                            data: "table"
                        },
                        encode: {
                            enter: {
                                x: {
                                    scale: "xscale",
                                    field: "category"
                                },
                                width: {
                                    scale: "xscale",
                                    band: 1
                                },
                                y: {
                                    scale: "yscale",
                                    field: "amount"
                                },
                                y2: {
                                    scale: "yscale",
                                    value: 0
                                },
                            },
                            update: {
                                fill: {
                                    value: "steelblue"
                                },
                            },
                            hover: {
                                fill: {
                                    value: "red"
                                },
                            },
                        },
                    },
                    {
                        type: "text",
                        encode: {
                            enter: {
                                align: {
                                    value: "center"
                                },
                                baseline: {
                                    value: "bottom"
                                },
                                fill: {
                                    value: "#333"
                                },
                            },
                            update: {
                                x: {
                                    scale: "xscale",
                                    signal: "tooltip.category",
                                    band: 0.5
                                },
                                y: {
                                    scale: "yscale",
                                    signal: "tooltip.amount",
                                    offset: -2
                                },
                                text: {
                                    signal: "tooltip.amount"
                                },
                                fillOpacity: [{
                                        test: "datum === tooltip",
                                        value: 0
                                    },
                                    {
                                        value: 1
                                    },
                                ],
                            },
                        },
                    },
                ],
            },
        }

        const chart = new google.visualization.VegaChart(
            document.getElementById("chart-div-2"),
        )
        chart.draw(dataTable, options)
    }
</script>
<script>
    google.charts.load("upcoming", {
        packages: ["vegachart"]
    }).then(drawChart)
    <?php
    require("../Home/connect.php");
    
$sql = "
SELECT 
    DATE(dh.ngay_tao) AS order_date,
    SUM(dh.tong_tien) AS total_revenue
FROM 
    don_hang dh
INNER JOIN 
    san_pham_dat_mua spdm ON dh.id_don_hang = spdm.id_don_hang
INNER JOIN 
    san_pham sp ON spdm.id_sp = sp.id_sp
GROUP BY 
    DATE(dh.ngay_tao)
ORDER BY 
    order_date ASC;
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row["order_date"], (float)$row["total_revenue"]];
    }
}
    ?>

    function drawChart() {
        const dataTable = new google.visualization.DataTable()
        dataTable.addColumn({
            type: "string",
            id: "category"
        })
        dataTable.addColumn({
            type: "number",
            id: "amount"
        })
        dataTable.addRows(<?php echo json_encode($data) ?>)
       



        const options = {
            vega: {
                $schema: "https://vega.github.io/schema/vega/v4.json",
                width: 500,
                height: 200,
                padding: 5,

                data: [{
                    name: "table",
                    source: "datatable"
                }],

                signals: [{
                    name: "tooltip",
                    value: {},
                    on: [{
                            events: "rect:mouseover",
                            update: "datum"
                        },
                        {
                            events: "rect:mouseout",
                            update: "{}"
                        },
                    ],
                }, ],

                scales: [{
                        name: "xscale",
                        type: "band",
                        domain: {
                            data: "table",
                            field: "category"
                        },
                        range: "width",
                        padding: 0.05,
                        round: true,
                    },
                    {
                        name: "yscale",
                        domain: {
                            data: "table",
                            field: "amount"
                        },
                        nice: true,
                        range: "height",
                    },
                ],

                axes: [{
                        orient: "bottom",
                        scale: "xscale"
                    },
                    {
                        orient: "left",
                        scale: "yscale"
                    },
                ],

                marks: [{
                        type: "rect",
                        from: {
                            data: "table"
                        },
                        encode: {
                            enter: {
                                x: {
                                    scale: "xscale",
                                    field: "category"
                                },
                                width: {
                                    scale: "xscale",
                                    band: 1
                                },
                                y: {
                                    scale: "yscale",
                                    field: "amount"
                                },
                                y2: {
                                    scale: "yscale",
                                    value: 0
                                },
                            },
                            update: {
                                fill: {
                                    value: "steelblue"
                                },
                            },
                            hover: {
                                fill: {
                                    value: "red"
                                },
                            },
                        },
                    },
                    {
                        type: "text",
                        encode: {
                            enter: {
                                align: {
                                    value: "center"
                                },
                                baseline: {
                                    value: "bottom"
                                },
                                fill: {
                                    value: "#333"
                                },
                            },
                            update: {
                                x: {
                                    scale: "xscale",
                                    signal: "tooltip.category",
                                    band: 0.5
                                },
                                y: {
                                    scale: "yscale",
                                    signal: "tooltip.amount",
                                    offset: -2
                                },
                                text: {
                                    signal: "tooltip.amount"
                                },
                                fillOpacity: [{
                                        test: "datum === tooltip",
                                        value: 0
                                    },
                                    {
                                        value: 1
                                    },
                                ],
                            },
                        },
                    },
                ],
            },
        }

        const chart = new google.visualization.VegaChart(
            document.getElementById("chart-div-3"),
        )
        chart.draw(dataTable, options)
    }
</script>