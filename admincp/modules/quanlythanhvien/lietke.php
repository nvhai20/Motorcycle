<?php
                             
    $sqli = "SELECT * FROM tbl_dangky,tbl_role where tbl_role.id_role  = tbl_dangky.role_id order by `id_dangky` ";
    $query = mysqli_query($mysqli, $sqli); 
     
?>
 <div class="row" style="margin-top: 50px;">
	<div class="col-md-12 table-responsive">
<h2>Liệt kê thành viên</h2>
<?php

if( $_SESSION['role_id'] == 1 ){
 ?>
<a href="index.php?action=quanlythanhvien&query=them"><button class="btn btn-success">Thêm Thành Viên</button></a>
<?php 
}else{
}
  ?>
<table class="table table-bordered table-hover" style="margin-top: 20px;">
    <thead>
<tr>
  	<th>STT</th>
    <th>Họ và tên</th>
    <th>Email</th>
    <th>Số điện thoại</th>
    <th>Địa chỉ</th>
    <th>Quyền</th>
    <th colspan="2">Quản lý</th>
  </tr>
    </thead>
    <tbody>
<?php 
  $i = 0;
  while($row = mysqli_fetch_array($query)){
   
    $i++;
  
    if($row['role_id']  != 1 && $row['role_id'] != 4){
?>
    <td><?php echo $i ?></td>
    <td><?php echo $row['tenkhachhang'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['dienthoai'] ?></td>
    <td><?php echo $row['diachi'] ?></td>
    <td><?php echo $row['name'] ?></td>  
    <?php

if( $_SESSION['role_id'] == 1 ){
 ?>
    <td>
      <a href="modules/quanlythanhvien/xuly.php?iddangky=<?php  echo $row['id_dangky']; ?>"><button  class="btn btn-danger">Xóa</button></a> </td>
 
      <?php 
}else{

  ?>
  <td width = "80px">Ẩn</td>
  <?php } ?>
  


   
  <?php

if( $_SESSION['role_id'] == 1 ){
 ?>

      <td>
      <a href="?action=quanlythanhvien&query=sua&iddangky=<?php echo $row['id_dangky']?> "><button class="btn btn-warning">Sửa</button></a>
    </td>

    <?php 
}else{

  ?>
  <td width = "80px">Ẩn</td>
  <?php } ?>
  

  </tr>

  <?php } ?>
  <?php
  }
  ?>
  </tbody>
</table>
  </div>
 </div>