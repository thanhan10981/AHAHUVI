<?php
require("../Home/connect.php");
// Truy vấn tổng doanh thu theo danh mục
$sql = "
SELECT 
    dm.ten_danh_muc AS category, 
    SUM(spdm.sl * spdm.gia) AS total_revenue
FROM 
    san_pham_dat_mua spdm
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
