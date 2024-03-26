<?php
// Phân trang
if(isset($_GET['trang'])){
    $page = $_GET['trang'];
}else{
    $page = '';
}
if($page == '' || $page == 1){
    $begin = 0;
}else{
    $begin = ($page*5)-5;
}

// Kiểm tra xem session 'id_khachhang' có tồn tại hay không
if(isset($_SESSION['id_khachhang'])){
    $userEmail = $_SESSION['id_khachhang']; // Lấy email của người dùng đã đăng nhập
    $sql_lietke_dh = "SELECT * FROM tbl_donhang
                      WHERE tbl_donhang.id_khachhang_temp = '$userEmail' 
                      ORDER BY tbl_donhang.id_donhang DESC LIMIT $begin, 5";
    
    $query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
    // Tiếp tục xử lý câu truy vấn và hiển thị kết quả


?>

<div class="row" style="margin-top: 20px;">
    <table class="table table-bordered table-hover" style="margin-top: 20px;text-align: center;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã đơn hàng</th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Thời gian tạo</th>
                <th>Tình trạng</th>
                <th>Xác nhận</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            if($query_lietke_dh != null) { // Kiểm tra nếu biến $query_lietke_dh không null
                while($row = mysqli_fetch_array($query_lietke_dh)){
                    $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['code_cart'] ?></td>
                <td><?php echo $row['tenkhachhang'] ?></td>
                <td><?php echo $row['diachi'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['dienthoai'] ?></td>
                <td><?php echo $row['ngaymua'] ?></td>
                <td>
                    <?php
                    if($row['cart_status'] == 1){
                        echo "Đã xác nhận";
                        ?>
                        <div class="clear"></div>
                        <a href="index.php?page=xemdonhang&query=xemdonhang&code=<?php echo $row['code_cart']; ?>">Xem đơn hàng</a>
                        <?php
                    } elseif($row['cart_status'] == 0) {
                        echo "Chờ xác nhận ";
                        ?>
                        <div class="clear"></div>
                        <a href="index.php?page=xemdonhang&query=xemdonhang&code=<?php echo $row['code_cart']; ?>">Xem đơn hàng</a>
                        <?php
                    } elseif($row['cart_status'] == 2){
                        echo "Đang giao hàng";
                        ?>
                        <div class="clear"></div>
                        <a href="index.php?page=xemdonhang&query=xemdonhang&code=<?php echo $row['code_cart']; ?>">Xem đơn hàng</a>
                        <?php
                    } elseif($row['cart_status'] == 3) {
                        echo "Đã giao";
                        ?>
                        <div class="clear"></div>
                        <a href="index.php?page=xemdonhang&query=xemdonhang&code=<?php echo $row['code_cart']; ?>">Xem đơn hàng</a>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($row['cart_status'] == 1) {
                        echo "";
                    } elseif ($row['cart_status'] == 2) {
                    ?>
                    <a href="index.php?page=xuly&query=xuly&code=<?php echo $row['code_cart']; ?>" class="btn btn-success">Đã nhận</a>
                    <?php       
                    } else {
                    ?>
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php
} else {
    // Nếu session 'id_khachhang' không tồn tại, gán giá trị NULL cho biến $query_lietke_dh
    $query_lietke_dh = null;
    echo "Vui lòng đăng nhập để xem đơn hàng";
}
// phân trang
     $sql_trang = mysqli_query($mysqli,"SELECT * FROM tbl_sanpham");
     $row_count = mysqli_num_rows($sql_trang);
     $trang = ceil($row_count/20);
     ?>
   <nav style="  width: 0%; margin: auto;margin-top: 70px;" aria-label="Page navigation example">
  <ul class="pagination">
      <a class="page-link" href="#" aria-label="Previous">    
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php              
                for($i=1;$i<=$trang;$i++){
                ?>
    <span class="page-item"><a class="page-link" <?php if($i == $page){echo 'style="background: #bfbfbf;"';}else{ echo ''; } ?> href="index.php?page=donhang&trang=<?php echo $i ?>"><?php echo $i ?></a></span>        
    <?php
             }
             ?>
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
</ul>   
