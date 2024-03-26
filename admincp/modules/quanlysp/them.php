<p>Thêm sản phẩm</p>
<form method="POST" action="modules/quanlysp/xuly.php" enctype="multipart/form-data">

<table border="1" width="100%" style="border-collapse: collapse;">
    <tr>
      <td>Tên sản phẩm</td>
      <td><input type="text" name="tensanpham"></td>
    </tr>
    <tr>
      <td>Mã sp</td>
      <td><input type="text" name="masp"></td>
    </tr>
    <tr>
      <td>Giá nhập</td>
      <td><input type="text" name="giagoc"></td>
    </tr>
    <tr>
      <td>Giá bán</td>
      <td><input type="text" name="giasp"></td>
    </tr>
    <tr>
      <td>Khuyến mãi (%)</td>
      <td><input type="text" name="giakm"></td>
    </tr>

    <tr class="mau-inputs">
      <td class="them_menu1">Màu sắc</td>
      <td class="them_menu2">
        <?php
        $sql_mau = "SELECT * FROM tbl_mau";
        $query_mau = mysqli_query($mysqli, $sql_mau);
        if ($query_mau) {
          while ($row_mau = mysqli_fetch_assoc($query_mau)) {
            echo '<div class="form-check form-check-inline">';
            echo '<input class="form-check-input mau-checkbox" type="checkbox" name="mau[]" value="' . $row_mau['id_mau'] . '">';
            echo '<label class="form-check-label">' . $row_mau['tenmau'] . '</label>';
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
    <td class="them_menu1">Số lượng và Hình ảnh (theo màu sắc)</td>
    <td class="them_menu2" id="soluonghinhanh-inputs">
        <!-- Input số lượng và hình ảnh sẽ được thêm vào đây bằng JavaScript -->
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
    // Hàm cập nhật tổng số lượng và giá trị của soluongmau
    function updateTotalQuantity() {
      var totalQuantity = 0;
      var soluongmauArray = {};

      $('.soluong-input').each(function () {
        var quantity = parseInt($(this).val()) || 0;
        var mauid = $(this).attr('data-mauid');
        totalQuantity += quantity;
        
        // Cập nhật giá trị số lượng cho màu tương ứng trong mảng
        soluongmauArray[mauid] = quantity;
      });

      $('#tong-soluong').val(totalQuantity);
      $('#soluongmau').val(JSON.stringify(soluongmauArray)); // Chuyển đổi mảng sang chuỗi JSON
    }

    // Sự kiện khi check/thay đổi tùy chọn màu sắc
    $('.mau-checkbox').change(function () {
      $('.soluonghinhanh-inputs').remove(); // Xóa bỏ các hàng cũ

      $('.mau-checkbox:checked').each(function () {
        var mauid = $(this).val();
        var mauname = $(this).siblings('label').text();

        var newRow = $('<tr class="soluonghinhanh-inputs"></tr>');

        // Input cho số lượng sản phẩm theo màu sắc
        var soluongHtml = '<td>Số lượng ' + mauname + '</td>' +
          '<td><input type="number" class="form-control soluong-input" data-mauid="'+ mauid +'" name="soluongmau[' + mauid + ']" required></td>';

        // Input cho hình ảnh của sản phẩm theo màu sắc
        var hinhanhHtml = '<td>Hình ảnh ' + mauname + '</td>' +
          '<td><input type="file" class="form-control hinhanh-input" name="hinhanhmau[' + mauid + ']" accept="image/*"></td>';

        newRow.append(soluongHtml + hinhanhHtml);
        newRow.insertAfter($(this).closest('tr'));
      });

      // Gắn sự kiện cập nhật tổng số lượng và mảng số lượng màu khi có thay đổi ở các input số lượng
      $('.soluong-input').on('input', updateTotalQuantity);
     
      // Cập nhật tổng số lượng lần đầu tiên khi có thay đổi ở các checkbox màu sắc
      updateTotalQuantity();
    });
  });
</script>




    <tr>
      <td>Tóm tắt</td>
      <td><textarea rows="10" name="tomtat" style="resize: none"></textarea></td>
    </tr>
    <tr>
      <td>Nội dung</td>
      <td><textarea rows="10" name="noidung" style="resize: none"></textarea></td>
    </tr>
    <tr>
      <td>Danh mục sản phẩm</td>
      <td>
        <select name="danhmuc">
          <?php
          $sql_danhmuc = "SELECT * FROM tbl_danhmuc";
          $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
          while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
            ?>
            <option value="<?php echo $row_danhmuc['id_danhmuc'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
          <?php
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
          <option value="1">Kích hoạt</option>
          <option value="0">Ẩn</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Thời gian ra mắt</td>
      <td><input type="text" name="thoigian"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="themsanpham" value="Thêm sản phẩm"></td>
    </tr>
</table>
</form>
