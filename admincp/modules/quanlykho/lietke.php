<?php
// phân trang
if(isset($_GET['trang'])){
    $page = $_GET['trang'];
} else {
    $page = '';
}
if($page == '' || $page == 1){
    $begin = 0;
} else {
    $begin = ($page * 20) - 20;
}

// Lấy giá trị danh mục từ form
$danhmuc = isset($_POST['danhmuc']) ? $_POST['danhmuc'] : '';

// Truy vấn SQL với điều kiện lọc theo danh mục sản phẩm (chỉ áp dụng khi có giá trị danh mục)
$sql_lietke_sp = "SELECT tbl_sanpham.*, tbl_danhmuc.*, tbl_sanpham_mau.soluongmau,tbl_sanpham_mau.soluongdaban, tbl_sanpham_mau.hinhanh
                 FROM tbl_sanpham
                 LEFT JOIN tbl_danhmuc ON tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmuc
                 LEFT JOIN tbl_sanpham_mau ON tbl_sanpham.id_sanpham = tbl_sanpham_mau.id_sanpham";

// Áp dụng điều kiện lọc nếu danh mục được chọn
if ($danhmuc != '') {
    $sql_lietke_sp .= " WHERE tbl_sanpham.id_danhmuc = '$danhmuc'";
}

$sql_lietke_sp .= " GROUP BY tbl_sanpham.id_sanpham
                   ORDER BY tbl_sanpham.id_sanpham DESC LIMIT $begin, 20";

$query_lietke_sp = mysqli_query($mysqli, $sql_lietke_sp);

?>

<!-- Các phần còn lại của mã HTML của bạn -->


<div class="quanlymenu">
                           
                           <div class="row" style="margin-top: 20px;">
                          <div class="col-md-12 table-responsive">
                            <h3 class="the_h">Quản Lý Kho</h3>
              
                            

<script>
    // Lưu tên danh mục khi thay đổi giá trị dropdown
    document.getElementById("danhmuc").addEventListener("change", function () {
        var selectedOption = this.options[this.selectedIndex];
        var selectedCategory = selectedOption.innerText;
        // Lưu tên danh mục vào một hidden field hoặc biến JavaScript
        // Ví dụ: lưu vào một hidden field có tên "selectedCategoryName"
        document.getElementById("selectedCategoryName").value = selectedCategory;
    });
</script>


    
                       


</div>

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
    <thead>
    <tr style="text-align: center;">
    <th>STT</th>
    <th>Tên</th>
    <th>Hình ảnh</th>
    <th>Số lượng nhập</th>
    <th>Số lượng đã bán</th>
    <th>Số lượng còn lại</th>
    <th>Danh mục</th>
    <th>Mã sản phẩm</th>
   
</thead>
<tbody>
<?php
$i = 0;
while($row = mysqli_fetch_array($query_lietke_sp)){
  $soluongcon = 0;
  $soluongcon = $row['soluongmau'] - $row['soluongdaban'];
  $i++;
?>
<tr style="text-align: center;">
    <td><?php echo $i ?></td>
    <td><?php echo $row['tensanpham'] ?></td>
    <td><img style="width:100px;max-height:100px" src="modules/quanlysp/uploads/<?php echo $row['hinhanh'] ?>"></td>
    <td><?php echo $row['soluongmau'] ?></td>

    <td><?php if($row['soluongdaban']==0){ echo "0"; }else{ echo $row['soluongdaban'] ; } ?></td> <!-- Hiển thị số lượng mua -->
    <td><?php echo $soluongcon ?></td>

    <td><?php echo $row['tendanhmuc'] ?></td>
    <!-- Hiển thị mã sản phẩm -->
    <td><?php echo $row['masp'] ?></td>
</tr> 
<?php
}
?>

</table>
<?php
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
    <span class="page-item"><a class="page-link" <?php if($i == $page){echo 'style="background: #bfbfbf;"';}else{ echo ''; } ?> href="index.php?action=quanlykho&query=lietke&trang=<?php echo $i ?>"><?php echo $i ?></a></span>        
    <?php
             }
             ?>
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>               
               </li>
  </ul>
</nav>