<?php
include('../../config/config.php');
$hinhanh = $_FILES['hinhanh']['name'];
$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
$hinhanh = time().'_'.$hinhanh;
if(isset($_POST['suaslide'])){

if(!empty($_FILES['hinhanh']['name'])){
        move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
        $sql_update = "UPDATE tbl_slide SET hinhanh='".$hinhanh."' WHERE id_slide='$_GET[idslide]' ";
       //xoa hinh anh cu
        $sql = "SELECT * FROM tbl_slide WHERE id_slide = '$_GET[idslide]' LIMIT 1";
        
		$query = mysqli_query($mysqli,$sql);
		while($row = mysqli_fetch_array($query)){
			unlink('uploads/'.$row['hinhanh']);
        }
		}else{
            $sql_update = "UPDATE tbl_slide SET hinhanh='".$hinhanh."',WHERE  id_slide='$_GET[idslide]'";
        }    
    mysqli_query($mysqli,$sql_update);
	header('Location:../../index.php?action=quanlyslide&query=lietke');

}
        ?>