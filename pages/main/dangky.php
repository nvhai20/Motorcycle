<?php
if (isset($_POST['dangky'])) {
    $tenkhachhang = $_POST['hovaten'];
    $email = $_POST['email'];
    $dienthoai = $_POST['dienthoai'];
    $matkhau = md5($_POST['matkhau']);
    $diachi = $_POST['diachi'];
    $sql_dangky = mysqli_query($mysqli, "INSERT INTO tbl_dangky(tenkhachhang,email,diachi,matkhau,dienthoai,role_id) VALUE('$tenkhachhang','$email','$diachi','$matkhau','$dienthoai',4)");
    if ($sql_dangky) {
        echo '<p style="color:red">Bạn đã đăng ký thành công</p>';
        $_SESSION['dangky'] =  $tenkhachhang;
        $_SESSION['id_khachhang'] =  mysqli_insert_id($mysqli);
        header('Location: index.php');
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
                    <label for="account">Họ và tên:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-user-circle'></i></span>
                        </div>
                        <input type="text" class="form-control" name="hovaten" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="form-group">
                    <label for="account">Email:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-envelope'></i></i></span>
                        </div>
                        <input type="text" class="form-control" name="email" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="form-group">
                    <label for="account">Điện thoại:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-phone'></i></i></span>
                        </div>
                        <input type="text" class="form-control" name="dienthoai" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="form-group">
                    <label for="account">Địa chỉ:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-location-plus'></i></span>
                        </div>
                        <input type="text" class="form-control" name="diachi" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i class='bx bxs-lock-alt'></i></span>
                        </div>
                        <input type="password" name="matkhau" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <?php echo (isset($err) ?  '<p style="color:red"><u>Email</u> hoặc <u>Mật khẩu</u> không đúng. Vui lòng thử lại !!!</p>' : "") ?>
                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <a href="index.php?page=dangnhap">Đã có tài khoản ?</a>
                    <button type="submit" name="dangky" class="btn btn-primary d-flex align-items-center">Đăng ký <i class='bx bx-right-arrow-alt'></i></button>
                </div>
            </form>
        </div>
    </div>
</div>