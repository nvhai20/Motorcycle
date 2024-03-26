<?php
$sql_bv = "SELECT * FROM tbl_baiviet WHERE tinhtrang=1 ORDER BY id DESC";
$query_bv = mysqli_query($mysqli, $sql_bv);

?>
<?php
$sql = "SELECT * FROM tbl_baiviet ORDER BY id DESC";
?>

<div class="container">
	<div class="text-center my-4">
		<span style="font-size:28px; font-weight:bold;"><u>Tin tức mới nhất</u></span>
	</div>
	<div class="row">
		<?php
		while ($row_bv = mysqli_fetch_array($query_bv)) {
		?>
			<div class="col-md-4">
				<img style="object-fit: cover; width:100%; height:300px;" src="admincp/modules/quanlybaiviet/uploads/<?php echo $row_bv['hinhanh'] ?>">
				<a class="my-2 text-overfl-2line" href=" index.php?page=baiviet&id=<?php echo $row_bv['id'] ?>">
					<?php echo $row_bv['tenbaiviet'] ?>
				</a>
				<span class="m-0 text-overfl-3line"><?php echo $row_bv['tomtat'] ?></span>
			</div>
		<?php
		}
		?>
	</div>
</div>