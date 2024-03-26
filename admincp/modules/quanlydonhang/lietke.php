<p>Liệt kê đơn hàng</p>
<?php
$condition = '';

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
  $condition = " AND code_cart LIKE '%$search%'";
}

// Phân trang
$limit = 30; // Số lượng đơn hàng trên mỗi trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Câu truy vấn
$sql_lietke_dh = "SELECT * FROM  tbl_donhang WHERE tbl_donhang.id_khachhang_temp ORDER BY tbl_donhang.id_donhang DESC LIMIT $offset, $limit";
$query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

if (!$query_lietke_dh) {
    die('Query Error: ' . mysqli_error($mysqli));
}

// Đếm tổng số đơn hàng (cần để tính số trang)
$sql_count = "SELECT COUNT(*) as total FROM tbl_cart WHERE 1 $condition";
$result_count = mysqli_query($mysqli, $sql_count);

if (!$result_count) {
    die('Query Error: ' . mysqli_error($mysqli));
}

$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Tính số trang
$total_pages = ceil($total_records / $limit);
?>

<form action="index.php" method="get" class="form-inline mt-2 mb-2">
    <input type="hidden" name="action" value="quanlydonhang">
    <input type="hidden" name="query" value="lietke">
    <input type="hidden" name="page" value="1"> <!-- Để đảm bảo page không bị trống -->
    <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm">
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
</form>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Mã đơn hàng</th>
      <th scope="col">Tên khách hàng</th>
      <th scope="col">Địa chỉ</th>
      <th scope="col">Email</th>
      <th scope="col">Số điện thoại</th>
      <th scope="col">Tình trạng</th>
      <th scope="col">Xem đơn hàng</th>
      <th scope="col">Thao tác</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $i = 0;
    while ($row = mysqli_fetch_array($query_lietke_dh)) {
      $i++;
      $code_cart = $row['code_cart'];
$status = $row['cart_status'];
    ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $row['code_cart'] ?></td>
        <td><?php echo $row['tenkhachhang'] ?></td>
        <td><?php echo $row['diachi'] ?></td>
        <td><?php echo $row['email'] ?></td>
        <td><?php echo $row['dienthoai'] ?></td>
        <td>
          <?php 

if ($status == 0) {
    echo '<a class="inputdonhang donhang-moi" href="#" onclick="confirmAction(' . $code_cart . ', \'moi\')">Đơn hàng mới</a>';
} elseif ($status == 1) {
    echo '<a class="inputdonhang donhang-chuanbi" href="#" onclick="confirmAction(' . $code_cart . ', \'chuanbi\')">Chuẩn bị hàng</a>';
} elseif ($status == 2) {
    echo '<a class="inputdonhang donhang-danggiao" href="#" onclick="confirmAction(' . $code_cart . ', \'danggiao\')">Giao hàng</a>';
} elseif ($status == 4) {
    echo '<span class="donhang-da-huy">Đã hủy</span>';
} else {
    echo '<span class="donhang-da-xac-nhan">Đã xác nhận</span>';
}


          ?>
        </td>
        <td>
          <a href="index.php?action=donhang&query=xemdonhang&code=<?php echo $row['code_cart'] ?>">Xem đơn hàng</a>
        </td>
        <td><a href="index.php?action=donhang&query=xuathoadon&code=<?php echo $row['code_cart'] ?>">Xuất HĐ </a> |
            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo $row['code_cart']; ?>')">
   Xóa</i> 
</a> 

            </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
        ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?action=quanlydonhang&query=lietke&page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>
<script>
function confirmAction(code_cart, status) {
    var result = confirm("Xác nhận " );

    if (result) {
        // Nếu người dùng chọn "Xác nhận", chuyển hướng hoặc thực hiện hành động cần thiết
        window.location.href = "modules/quanlydonhang/xuly.php?code=" + code_cart + "&status=" + status;
    } else {
        // Nếu người dùng chọn "Hủy", không làm gì cả
      
    }
}
    document.getElementById("filterStatus").addEventListener("change", function() {
        filterByStatus();
    });

    function filterByStatus() {
        var statusFilter = document.getElementById("filterStatus").value;
        var rows = document.getElementById("donhangTable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var rowStatus = rows[i].getAttribute("data-status");

            if (statusFilter === "all" || rowStatus === statusFilter) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
    function confirmDelete(codeCart) {
        var confirmDelete = confirm("Bạn có chắc chắn muốn xóa?");
        if (confirmDelete) {
            // Nếu xác nhận, chuyển hướng đến xử lý xóa
            window.location.href = 'modules/quanlydonhang/xuly.php?idcart=' + codeCart;
        } else {
            // Nếu hủy, không thực hiện hành động nào
        }
    }
</script>
<style>
    .donhang-moi { color: blue; }
    .donhang-chuanbi { color: orange; }
    .donhang-danggiao { color: green; }
    .donhang-da-huy { color: red; }
    .donhang-da-xac-nhan { color: purple; }
</style>
