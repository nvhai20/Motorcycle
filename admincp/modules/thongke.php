<?php

include('../config/config.php');

$timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
$now = new DateTime('now', $timezone);
$nowDateString = $now->format('Y-m-d');

if (isset($_POST['thoigian'])) {
    $thoigian = $_POST['thoigian'];
} else {
    $thoigian = '';
    $subdays = date('Y-m-d', strtotime('-365 days'));
}

if ($thoigian == '7ngay') {
    $subdays = date('Y-m-d', strtotime('-7 days'));
} elseif ($thoigian == '28ngay') {
    $subdays = date('Y-m-d', strtotime('-28 days'));
} elseif ($thoigian == '90ngay') {
    $subdays = date('Y-m-d', strtotime('-90 days'));
} elseif ($thoigian == '365ngay') {
    $subdays = date('Y-m-d', strtotime('-365 days'));
}

$now = new DateTime('now', $timezone);
$nowDateString = $now->format('Y-m-d');
$sql = "SELECT
DATE(dh.ngaymua) AS ngaymua,
COUNT(dh.id_donhang) AS donhang,
SUM(cd.soluongmua) AS soluongban,
SUM(cd.soluongmua * sp.giasp) AS doanhthu,
SUM(cd.soluongmua * sp.giagoc) AS gianhap,
(SUM(cd.soluongmua * sp.giasp) - SUM(cd.soluongmua * sp.giagoc)) AS loinhuan
FROM tbl_donhang dh
LEFT JOIN (
SELECT code_cart, id_sanpham, SUM(soluongmua) AS soluongmua
FROM tbl_cart_details
WHERE code_cart IN (
    SELECT code_cart
    FROM tbl_donhang
    WHERE cart_status = 3 AND ngaymua BETWEEN '2020/01/01' AND '2024/03/02 '
)
GROUP BY code_cart, id_sanpham
) cd ON dh.code_cart = cd.code_cart
LEFT JOIN tbl_sanpham sp ON cd.id_sanpham = sp.id_sanpham
WHERE dh.ngaymua BETWEEN '2020/01/01' AND '2024/03/02' AND dh.cart_status = 3
GROUP BY DATE(dh.ngaymua)
ORDER BY DATE(dh.ngaymua) ASC;
;
";

$sql_query = mysqli_query($mysqli, $sql);

while ($val = mysqli_fetch_array($sql_query)) {
    $chart_data[] = array(
        'date' => $val['ngaymua'],
        'donhang' => $val['donhang'],
        'soluong' => $val['soluongban'],
        'doanhthu' => $val['doanhthu'],
        'gianhap' => $val['gianhap'],
        'loinhuan' => $val['loinhuan'],
    );
}

echo $data = json_encode($chart_data);
?>
