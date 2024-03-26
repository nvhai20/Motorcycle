<?php
  
   if(isset($_POST["dangnhap"])){
        $email=$_POST['email'];
        $matkhau=md5($_POST['password']);
        $sql=  "SELECT * FROM tbl_dangky WHERE email = '".$email."' AND matkhau='".$matkhau."' LIMIT 1";   
        $row=mysqli_query($mysqli,$sql);
        $count = mysqli_num_rows($row);
          if($count>0){
              $row_data = mysqli_fetch_array($row);
            $_SESSION['dangky'] = $row_data['tenkhachhang'];
            $_SESSION['id_khachhang'] = $row_data['id_dangky'];
			$_SESSION['role_id'] = $row_data['role_id'];
			
			$_SESSION['email'] = $row_data['email'];
			if($_SESSION['role_id'] == 4){
           header ("Location:index.php");
        }else{
            header ("Location:admincp/index.php?action=dashboard&query=lietke");
        }
    } else {
        $err = true;
    }
}
?>

<div class="container">
    <div class="d-flex align-items-center justify-content-center " style="min-height: 70vh;">
        <div style="flex-grow: 0.3;">
            <form autocomplete="off" method="POST">
                <div class="text-center" style="font-size: 20px; font-weight:bold;">
                    <img width="100" src="../../images/user.png" alt="">
                </div>
                <div class="form-group">
                    <label for="account">Email:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-user-circle'></i></span>
                        </div>
                        <input type="text" class="form-control" name="email" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-lock-alt'></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <?php echo (isset($err) ?  '<p style="color:red"><u>Email</u> hoặc <u>Mật khẩu</u> không đúng. Vui lòng thử lại !!!</p>' : "") ?>
                <div class="d-flex justify-content-between mb-3">
                    <a href="index.php?page=dangky">Chưa có tài khoản</a>
                    <a href="">Quên mật khẩu</a>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" name="dangnhap" class="btn btn-primary d-flex align-items-center">Đăng nhập <i class='bx bx-right-arrow-alt'></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
