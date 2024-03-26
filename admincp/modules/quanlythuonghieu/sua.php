<?php
$sql_sua_thuonghieu = "SELECT * FROM tbl_thuonghieu WHERE id_thuonghieu='$_GET[idthuonghieu]' LIMIT 1";
$query_sua_thuonghieu = mysqli_query($mysqli, $sql_sua_thuonghieu);
?>
<p>Sửa thương hiệu</p>
<table border="1" width="50%" style="border-collapse: collapse;">
  <form method="POST" action="modules/quanlythuonghieu/xuly.php?idthuonghieu=<?php echo $_GET['idthuonghieu'] ?>">
    <?php
    while ($dong = mysqli_fetch_array($query_sua_thuonghieu)) {
    ?>
      <tr>
        <td>Tên thương hiệu</td>
        <td><input type="text" value="<?php echo $dong['tenthuonghieu'] ?>" name="tenthuonghieu"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="suathuonghieu" value="Sửa thương hiệu"></td>
      </tr>
    <?php
    }
    ?>
  </form>
</table>