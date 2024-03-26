<p>Xem đơn hàng</p>
<?php
$code = $_GET['code'];
$sql_lietke_dh = "SELECT tbl_cart_details.*, tbl_sanpham.*, tbl_mau.tenmau
FROM tbl_cart_details
INNER JOIN tbl_sanpham ON tbl_cart_details.id_sanpham = tbl_sanpham.id_sanpham
INNER JOIN tbl_mau ON tbl_cart_details.mau = tbl_mau.id_mau
WHERE tbl_cart_details.code_cart = '".$code."'
ORDER BY tbl_cart_details.id_cart_details DESC
";$query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
?>
<table style="width:100%" border="1" style="border-collapse: collapse;">
  <tr>
    <th>Id</th>
    <th>Mã đơn hàng</th>
    <th>Tên sản phẩm</th>
    <th>Màu sắc</th>
    <th>Số lượng</th>
    <th>Đơn giá</th>
    <th>Thành tiền</th>


  </tr>
  <?php
  $i = 0;
  $tongtien = 0;
  while ($row = mysqli_fetch_array($query_lietke_dh)) {
    $i++;
    if ($row['giakm'] > 0) {
      $giaspkm = $row['giasp'] - ($row['giasp'] * ($row['giakm'] / 100));
    } else {
      $giaspkm = $row['giasp'];
    }
    $thanhtien = $giaspkm * $row['soluongmua'];
    $tongtien += $thanhtien;
  ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['code_cart'] ?></td>
      <td><?php echo $row['tensanpham'] ?></td>
      <td><?php echo $row['tenmau'] ?></td>

      <td><?php echo $row['soluongmua'] ?></td>
      <th><?php echo number_format($giaspkm) . 'đ' ?></th>
      <td><?php echo number_format($thanhtien) . ' vnđ' ?></td>

    </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="6">
      <p style="color:red; font-weight : 500;">Tổng tiền : <?php echo number_format($tongtien, 0, ',', '.') . 'vnđ' ?></p>
    </td>

  </tr>

</table>
