<?php
include('../../config/config.php');

$tenloaisp = $_POST['tenthuonghieu'];
if (isset($_POST['themthuonghieu'])) {
	//them
	$sql_them = "INSERT INTO tbl_thuonghieu(tenthuonghieu) VALUE('" . $tenloaisp . "')";
	mysqli_query($mysqli, $sql_them);
	header('Location:../../index.php?action=quanlythuonghieu&query=them');
} elseif (isset($_POST['suathuonghieu'])) {
	//sua
	$sql_update = "UPDATE tbl_thuonghieu SET tenthuonghieu='" . $tenloaisp .  "' WHERE id_thuonghieu='$_GET[idthuonghieu]'";
	mysqli_query($mysqli, $sql_update);
	header('Location:../../index.php?action=quanlythuonghieu&query=them');
} else {
	$id = $_GET['idthuonghieu'];
	$sql_xoa = "DELETE FROM tbl_thuonghieu WHERE id_thuonghieu='" . $id . "'";
	mysqli_query($mysqli, $sql_xoa);
	header('Location:../../index.php?action=quanlythuonghieu&query=them');
}
