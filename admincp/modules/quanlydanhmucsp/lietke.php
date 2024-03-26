<?php
$sql_lietke_danhmucsp = "SELECT * FROM tbl_danhmuc ";
$query_lietke_danhmucsp = mysqli_query($mysqli, $sql_lietke_danhmucsp);
?>
<h3>Liệt kê danh mục sản phẩm</h3>

<div class="col-md-6 table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr style="text-align: center;" >
    <th>STT</th>
   <th>Tên danh mục</th>
   <th style="text-align: center;" colspan="2"></th>
					
  </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_danhmucsp)) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tendanhmuc'] ?></td>
                <td>
                    <a href="modules/quanlydanhmucsp/xuly.php?iddanhmuc=<?php echo $row['id_danhmuc'] ?>"><button  class="btn btn-danger">Xóa</button></a> |
                    <a href="?action=quanlydanhmucsanpham&query=sua&iddanhmuc=<?php echo $row['id_danhmuc'] ?>"><button class="btn btn-warning">Sửa</button> </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>