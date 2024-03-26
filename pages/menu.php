<?php
$sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
$query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
?>
<div class="" style="background:#dcdcdc;position:sticky;top: 0;z-index:100000;">
	<ul class="p-0 py-1 container d-flex justify-content-center">
		<li class="py-2 px-4"><a class="text-dark" href="index.php">Trang chủ</a></li>
		<li class="py-2 px-4"><a class="text-dark" href="index.php?page=tatcasanpham">Sản phẩm</a></li>
		<?php
		$sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC LIMIT 5";
		$query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
		while ($row = mysqli_fetch_array($query_danhmuc)) {
		?>
			<li class="py-2 px-4"><a class="text-dark" href="index.php?page=tatcasanpham&danhmuc=<?php echo $row['id_danhmuc'] ?>"><?php echo $row['tendanhmuc'] ?></a></li>
		<?php
		}
		?>
		<li class="py-2 px-4"><a class="text-dark" href="index.php?page=tintuc">Tin tức</a></li>
		<li class="py-2 px-4"><a class="text-dark" href="index.php?page=lienhe">Liên hệ</a></li>
		<li class="py-2 px-4"><a class="text-dark" href="index.php?page=donhang">Đơn hàng</a></li>

	</ul>
</div>