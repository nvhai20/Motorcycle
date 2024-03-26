<?php
if(isset($_POST['phanhoi'])) {
  // Lấy nội dung phản hồi từ form
  $noidung = mysqli_real_escape_string($mysqli, $_POST['noidung']);
	$code = $_GET['code_cart'];

  // Chèn nội dung phản hồi vào bảng tbl_hoanhang trong cơ sở dữ liệu

  if ($insert_feedback_query) {
    header('Location:chitiet.php?quanly=camon');

  } else {
      echo "Lỗi: " . mysqli_error($mysqli);
  }
}
?>
<div class="pyro"><div class="before"></div><div class="after"></div></div>
<div class="login-form">
	<div class="login-container">
	<a href="./index.php" class="header-zz">
        <div class="logo-wrapper">
        </div>
    </a>
  <h2 class="display-3">CẢM ƠN QUÝ KHÁCH</h2>
  <p class="lead"><strong>Làm ơn hãy kiểm tra Email .</strong>Để được nhận thông báo </p>
  <hr>
  <p>
     <a href="index.php?page=xuathoadon&code=<?php echo $_GET['code_cart']; ?>">Xuất hóa đơn--></a>
  </p>
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="index.php?page=danhmucsp&id=1" role="button">Ấn vào đây để tiếp tục mua hàng</a>
  </p>
</div>
<div class="clear"></div>
</div>

</div>
