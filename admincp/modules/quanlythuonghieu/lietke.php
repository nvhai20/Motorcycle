<?php
$sql_lietke_thuonghieu = "SELECT * FROM tbl_thuonghieu ";
$query_lietke_thuonghieu = mysqli_query($mysqli, $sql_lietke_thuonghieu);
?>
<p>Liệt kê thương hiệu</p>


<div class="col-md-6 table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr style="text-align: center;" >
            <th scope="col">#</th>
            <th scope="col">Tên thương hiệu</th>
            <th scope="col">Quản lý</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_thuonghieu)) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tenthuonghieu'] ?></td>
                <td>
                    <a href="modules/quanlythuonghieu/xuly.php?idthuonghieu=<?php echo $row['id_thuonghieu'] ?>"><button  class="btn btn-danger">Xóa</button></a> |
                    <a href="?action=quanlythuonghieu&query=sua&idthuonghieu=<?php echo $row['id_thuonghieu'] ?>"><button class="btn btn-warning">Sửa</button> </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>