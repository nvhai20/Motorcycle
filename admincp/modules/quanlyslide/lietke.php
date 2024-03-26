<?php
	$sql_lietke_slide = "SELECT * FROM tbl_slide ORDER BY danhmuc DESC";
	$query_lietke_slide = mysqli_query($mysqli,$sql_lietke_slide);
?>
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 class="the_h">Quản lý slide</h3>
        <table class="table table-bordered table-hover" style="margin-top: 20px;">
		<thead>
  <tr style="text-align: center;" >
  <th>STT</th>
    <th>Ảnh Slide</th>
    <th>Quản lý</th>
  </tr>
  <?php
  $i = 0;
  while($row = mysqli_fetch_array($query_lietke_slide)){
  	$i++;
  ?>
  <tr style="text-align: center;" >
  <td><?php echo $i ?></td>
  <td><img src="modules/quanlyslide/uploads/<?php echo $row['hinhanh'] ?>" width="150px"></td>
   		<td> <a href="?action=quanlyslide&query=sua&idslide=<?php echo $row['id_slide'] ?>"><button class="btn btn-warning">Sửa</button></a> 
   	</td>
  </tr>
  <?php } ?>
  </table>