<?php
$sql_sua_sp = "SELECT * FROM tbl_sanpham WHERE id_sanpham='$_GET[idsanpham]' LIMIT 1";
$query_sua_sp = mysqli_query($mysqli, $sql_sua_sp);
?>
<p>Sửa sản phẩm</p>
<table border="1" width="100%" style="border-collapse: collapse;">
  <?php
  while ($row = mysqli_fetch_array($query_sua_sp)) {
    $product_id = $row['id_sanpham'];
  ?>
    <form method="POST" action="modules/quanlysp/xuly.php?idsanpham=<?php echo $row['id_sanpham'] ?>" enctype="multipart/form-data">
      <tr>
        <td>Tên sản phẩm</td>
        <td><input type="text" value="<?php echo $row['tensanpham'] ?>" name="tensanpham"></td>
      </tr>
      <tr>
        <td>Mã sp</td>
        <td><input type="text" value="<?php echo $row['masp'] ?>" name="masp"></td>
      </tr>
      <tr>
        <td>Giá bán</td>
        <td><input type="text" value="<?php echo $row['giasp'] ?>" name="giasp"></td>
      </tr>
      <tr>
        <td>Giá nhập</td>
        <td><input type="text" value="<?php echo $row['giagoc'] ?>" name="giagoc"></td>
      </tr>
      <tr>
      <td>Khuyến mãi (%)</td>
      <td><input type="text" name="giakm" value="<?php echo $row['giakm'] ?>"></td>
    </tr>
    <tr class="mau-inputs">
    <td class="them_menu1">Màu sắc</td>
    <td class="them_menu2">
        <?php
        $sql_mau = "SELECT * FROM tbl_mau";
        $query_mau = mysqli_query($mysqli, $sql_mau);
        if ($query_mau) {
            // Lặp qua tất cả các màu từ bảng tbl_mau
            while ($row_mau = mysqli_fetch_assoc($query_mau)) {
                $mauid = $row_mau['id_mau'];
                $tenmau = $row_mau['tenmau'];
                // Kiểm tra xem màu này đã được chọn trong sản phẩm hay không
                $checked = '';
                // Truy vấn để kiểm tra xem màu có tồn tại trong bảng tbl_sanpham_mau không
                $sql_check = "SELECT * FROM tbl_sanpham_mau WHERE id_sanpham = $product_id AND id_mau = $mauid";
                $query_check = mysqli_query($mysqli, $sql_check);
                if (mysqli_num_rows($query_check) > 0) {
                    $checked = 'checked';
                }
                echo '<div class="form-check form-check-inline">';
                echo '<input class="form-check-input mau-checkbox" type="checkbox" name="mau[]" value="' . $mauid . '" ' . $checked . '>';
                echo '<label class="form-check-label">' . $tenmau . '</label>';
                echo '</div>';
            }
        } else {
            die("Không thể lấy dữ liệu từ cơ sở dữ liệu.");
        }
        ?>
        <a href="index.php?action=quanlysp&query=mau">Thêm </a>
    </td>
</tr>


<tr class="soluonghinhanh-inputs">
    <td class="them_menu1">Sửa thông tin số lượng và Hình ảnh (theo màu sắc)</td>
    <td class="them_menu2" id="soluonghinhanh-inputs">
        <!-- Các thông tin số lượng và hình ảnh sẽ được tải từ bảng tbl_sanpham_mau và hiển thị ở đây -->
        <?php
        // Truy vấn để lấy thông tin từ bảng tbl_sanpham_mau
        $sql_mau = "SELECT * FROM tbl_sanpham_mau WHERE id_sanpham = $product_id";
        $query_mau = mysqli_query($mysqli, $sql_mau);
        if ($query_mau) {
            while ($row_mau = mysqli_fetch_assoc($query_mau)) {
                $mauid = $row_mau['id_mau'];
                $soluongmau = $row_mau['soluongmau'];
                $hinhanhmau = $row_mau['hinhanh'];

                // Truy vấn để lấy tên màu từ bảng tbl_mau
                $sql_tenmau = "SELECT tenmau FROM tbl_mau WHERE id_mau = $mauid";
                $query_tenmau = mysqli_query($mysqli, $sql_tenmau);
                $row_tenmau = mysqli_fetch_assoc($query_tenmau);
                $tenmau = $row_tenmau['tenmau'];

                // Hiển thị input cho số lượng sản phẩm, hình ảnh và ô hiển thị ảnh theo màu sắc
                echo '<div>';
                echo '<div class="v3211"><label class="mau-label" style="background-color: ' . $tenmau . ';"></label><p style="color: black;FONT-WEIGHT: 500;">' . $tenmau . '</p></div>';
                echo '<input type="number" class="form-control soluong-input" data-mauid="' . $mauid . '" name="soluongmau[' . $mauid . ']" value="' . $soluongmau . '" required>';
                echo '<input type="file" class="form-control hinhanh-input" name="hinhanhmau[' . $mauid . ']" accept="image/*" value="' . $hinhanhmau . '">';
                echo '<img src="modules/quanlysp/uploads/' . $hinhanhmau . '" alt="' . $tenmau . ' ảnh" style="width: 50px;">'; // Hiển thị ảnh 50px
                echo '</div>';
            }
        } else {
            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
        }
        ?>
    </td>
</tr>

<tr>
    <td class="them_menu1">Tổng số lượng</td>
    <td class="them_menu2">
        <input type="number" id="tong-soluong" name="tongsoluong" value="0" readonly>
        <input type="hidden" name="soluongmau" id="soluongmau" value="">
    </td>
</tr>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    function updateTotalQuantityAndImages() {
        var totalQuantity = 0;
        var soluongmauArray = {};

        $('.soluong-input').each(function () {
            var quantity = parseInt($(this).val()) || 0;
            var mauid = $(this).attr('data-mauid');
            totalQuantity += quantity;
            soluongmauArray[mauid] = quantity;

            // Kiểm tra nếu có chọn ảnh mới thì cập nhật, không thì giữ nguyên giá trị ẩn
            var hinhanhNewValue = $(this).closest('div').find('.hinhanh-new-input').val();
            if (hinhanhNewValue) {
                // Cập nhật đường dẫn ảnh mới vào mảng nếu người dùng chọn ảnh mới
                soluongmauArray['hinhanhmoi_' + mauid] = hinhanhNewValue;
            } else {
                // Nếu không thì lấy giá trị đường dẫn ảnh cũ từ input ẩn
                var hinhanhCurrentValue = $(this).closest('div').find('.hinhanh-current-input').val();
                soluongmauArray['hinhanh_' + mauid] = hinhanhCurrentValue;
            }
        });

        $('#tong-soluong').val(totalQuantity);
        $('#soluongmau').val(JSON.stringify(soluongmauArray));
    }

    // Gắn sự kiện cho cả số lượng và input đường dẫn ảnh mới
    $('.soluong-input, .hinhanh-new-input').on('input', updateTotalQuantityAndImages);

    updateTotalQuantityAndImages(); // Gọi hàm ngay khi trang tải
});

</script>



      <tr>
        <td>Tóm tắt</td>
        <td><textarea row="10" name="tomtat" style="resize: none"><?php echo $row['tomtat'] ?></textarea></td>
      </tr>
      <tr>
        <td>Nội dung</td>
        <td><textarea row="10" name="noidung" style="resize: none"><?php echo $row['noidung'] ?></textarea></td>
      </tr>
      <tr>
        <td>Danh mục sản phẩm</td>
        <td>
          <select name="danhmuc">
            <?php
            $sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
            $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
            while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
              if ($row_danhmuc['id_danhmuc'] == $row['id_danhmuc']) {
            ?>
                <option selected value="<?php echo $row_danhmuc['id_danhmuc'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
              <?php
              } else {
              ?>
                <option value="<?php echo $row_danhmuc['id_danhmuc'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
            <?php
              }
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Thương hiệu</td>
        <td>
          <select name="thuonghieu">
            <?php
            $thuonghieu = "SELECT * FROM tbl_thuonghieu";
            $query_thuonghieu = mysqli_query($mysqli, $thuonghieu);
            while ($row_thuonghieu = mysqli_fetch_array($query_thuonghieu)) {
            ?>
              <option value="<?php echo $row_thuonghieu['id_thuonghieu'] ?>"><?php echo $row_thuonghieu['tenthuonghieu'] ?></option>
            <?php
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Tình trạng</td>
        <td>
          <select name="tinhtrang">
            <?php
            if ($row['tinhtrang'] == 1) {
            ?>
              <option value="1" selected>Kích hoạt</option>
              <option value="0">Ẩn</option>
            <?php
            } else {
            ?>
              <option value="1">Kích hoạt</option>
              <option value="0" selected>Ẩn</option>
            <?php
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Thời gian ra mắt</td>
        <td><input type="text" value="<?php echo $row['thoigian'] ?>" name="thoigian"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="suasanpham" value="Sửa sản phẩm"></td>
      </tr>
    </form>
  <?php
  }
  ?>
</table>
<style>
    .mau-label {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        line-height: 30px;
    }
 .v3211 {
    display: flex;
    gap: 20px;
}
</style>
