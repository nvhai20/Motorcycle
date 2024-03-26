

<?php
include('../../config/config.php');
$email = $_POST['email'];
$matkhau = md5($_POST['matkhau']);
$tenkhachhang = $_POST['hovaten'];

$id_role = $_POST['role_id'];
$dienthoai = $_POST['dienthoai'];
$diachi = $_POST['diachi'];
if(isset($_POST['suathanhvien'])){

       
        $sql_update = "UPDATE tbl_dangky SET tenkhachhang = '".$tenkhachhang."',email = '".$email."',diachi = '".$diachi."', matkhau = '".$matkhau."',dienthoai = '".$dienthoai."' ,role_id = '".$id_role."' WHERE id_dangky='$_GET[iddangky]' ";
       //xoa hinh anh cu
        $sql = "SELECT * FROM tbl_dangky WHERE id_dangky = '$_GET[iddangky]' LIMIT 1";
		$query = mysqli_query($mysqli,$sql);
	
		
          
    mysqli_query($mysqli,$sql_update);
    header('Location:../../index.php?action=quanlythanhvien&query=lietke');
}  else{
    $id = $_GET['iddangky'];
    $sql_xoa = "DELETE FROM tbl_dangky WHERE id_dangky = '".$id."'";
    mysqli_query($mysqli,$sql_xoa);
    
    
    header('Location:../../index.php?action=quanlythanhvien&query=lietke');
    }   
    
        ?>











