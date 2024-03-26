<div class="container">
  <div style="min-height:60vh;">
    <div class="text-right mt-3 mb-1">
      <?php echo (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? "Hiện đang có " . count($_SESSION['cart']) . " sản phẩm trong giỏ hàng !" : "Chưa có sản phẩm nào !") ?>
    </div>
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>#</th>
          <th>Mã sp</th>
          <th>Tên sản phẩm</th>
          <th>Hình ảnh</th>
          <th>Màu sắc</th>
          <th>Số lượng</th>
          <th>Giá sản phẩm</th>
          <th>Thành tiền</th>
          <th>Quản lý</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_SESSION['cart'])) {
          $i = 0;
          $tongtien = 0;
          foreach ($_SESSION['cart'] as $cart_item) {
            $thanhtien = $cart_item['soluong'] * (int)str_replace('.', '', (string)$cart_item['giasp']);
            $tongtien += $thanhtien;
            $i++;
        ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $cart_item['masp']; ?></td>
              <td><?php echo $cart_item['tensanpham']; ?></td>
              <td><img src="admincp/modules/quanlysp/uploads/<?php echo $cart_item['hinhanh']; ?>" width="150px"></td>
              <td>
    <?php
    $mau_id = $cart_item['mau']; // ID của màu từ session
    $sql_mau = "SELECT * FROM tbl_mau WHERE id_mau = $mau_id";
    $query_mau = mysqli_query($mysqli, $sql_mau);
    
    if ($row_mau = mysqli_fetch_assoc($query_mau)) {
        $tenmau = $row_mau['tenmau'];
        $mau_hex = $row_mau['id_mau']; // Giả sử có trường lưu mã hex của màu

        // Hiển thị tên màu và hình tròn màu
        echo '<div style="display: flex; align-items: center;">';
        echo '<div style="width: 20px; height: 20px; border-radius: 50%; background-color: ' . $tenmau . '; margin-right: 8px;"></div>';
        echo $tenmau;
        echo '</div>';
    } else {
        echo 'Màu không xác định';
    }
    ?>
</td>

              <td>
              <a style="text-decoration: none;" href="pages/main/themgiohang.php?tru=<?php echo $cart_item['id'] ?>"><i class="cong_tru">-</i></a>
                <?php echo $cart_item['soluong']; ?>
                <a style="text-decoration: none;" href="pages/main/themgiohang.php?cong=<?php echo $cart_item['id'] ?>"><i class="cong_tru">+</i></a>

              </td>
              <td><?php echo number_format($cart_item['giasp']) . ' VND'; ?></td>
              <td><?php echo number_format((float)$thanhtien, 0, ',', '.') . ' VND' ?></td>
              <td><a style="text-decoration: none;" href="pages/main/themgiohang.php?xoa=<?php echo $cart_item['id'] ?>">Xóa</a></td>
            </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="9">
              <p style="float: left;">Tổng tiền: <?php echo number_format($tongtien, 0, ',', '.') . ' VND' ?></p><br>
              <p style="float: right;"><a style="text-decoration: none;border: 1px solid #aa6342;" href="pages/main/themgiohang.php?xoatatca=1"> Xóa tất cả </a></p>
              <div style="clear: both;"></div>

                <p><a style="text-decoration: none; border:1px solid #aa6342;padding:10px;background:brown;color:#fff;" href="index.php?page=thongtinthanhtoan">Đặt hàng</a></p>



            </td>
          </tr>
        <?php
        } else {
        ?>
          <tr>
            <td colspan="9">
              <p class="text-center">Hiện tại giỏ hàng trống</p>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>