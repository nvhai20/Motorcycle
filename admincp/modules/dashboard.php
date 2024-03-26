<?php
// Kiểm tra xem dữ liệu đã được gửi từ form hay không
if(isset($_POST['subdays']) && isset($_POST['now'])){
    // Chuyển đổi giá trị ngày sang định dạng Y-m-d
    $subdays = date("Y-m-d", strtotime($_POST['subdays']));
    $now = date("Y-m-d", strtotime($_POST['now']));
} else {
    // Nếu không có dữ liệu được gửi từ form, đặt giá trị mặc định là ngày hôm nay
    $subdays = date("Y-m-d");
    $now = date("Y-m-d");
}

// Hiển thị ngày theo định dạng mong muốn
$subdaysHienThi = date("d - m - Y", strtotime($subdays));
$nowHienThi = date("d - m - Y", strtotime($now));
?>




<div class="quanlymenu">
<p>Thống kê đơn hàng theo : <span id="text-date"></span></p>
<p>
	<select class="select-date">
	<option value="">Thống kê chi tiết</option>

		<option value="7ngay">7 ngày qua</option>
		<option value="28ngay">28 ngày qua</option>
		<option value="90ngay">90 ngày qua</option>
		<option value="365ngay">365 ngày qua</option>
	</select>
</p>
<div id="chart" style="height: 250px;"></div>
<?php
    include('config/config.php');

// thống kê bằng ajax
$timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
$now = new DateTime('now', $timezone);
$nowDateString = $now->format('Y-m-d');

if (isset($_POST['thoigian'])) {
    $thoigian = $_POST['thoigian'];
} else {
    $thoigian = '';
    $subdays = (new DateTime('now', $timezone))->sub(new DateInterval('P365D'))->format('Y-m-d');
}

if ($thoigian == '7ngay') {
    $subdays = (new DateTime('now', $timezone))->sub(new DateInterval('P7D'))->format('Y-m-d');
} elseif ($thoigian == '28ngay') {
    $subdays = (new DateTime('now', $timezone))->sub(new DateInterval('P28D'))->format('Y-m-d');
} elseif ($thoigian == '90ngay') {
    $subdays = (new DateTime('now', $timezone))->sub(new DateInterval('P90D'))->format('Y-m-d');
} elseif ($thoigian == '365ngay') {
    $subdays = (new DateTime('now', $timezone))->sub(new DateInterval('P365D'))->format('Y-m-d');
}

$now = (new DateTime('now', $timezone))->format('Y-m-d');

$sql = "SELECT
    DATE_FORMAT(dh.ngaymua, '%Y-%m-%d 00:00:00') AS ngaymua,
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
        WHERE cart_status = 3 AND ngaymua BETWEEN '$subdays 00:00:00' AND '$nowDateString 00:00:00'
    )
    GROUP BY code_cart, id_sanpham
) cd ON dh.code_cart = cd.code_cart
LEFT JOIN tbl_sanpham sp ON cd.id_sanpham = sp.id_sanpham
WHERE dh.ngaymua BETWEEN '$subdays 00:00:00' AND '$nowDateString 00:00:00' AND dh.cart_status = 3
GROUP BY DATE_FORMAT(dh.ngaymua, '%Y-%m-%d 00:00:00')
ORDER BY DATE_FORMAT(dh.ngaymua, '%Y-%m-%d 00:00:00') ASC";

$sql_query = mysqli_query($mysqli, $sql);

$chart_data = array();

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


   
?>
</div>

<?php include"thongkechitiet.php"; ?>
