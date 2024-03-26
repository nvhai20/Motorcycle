<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$condition = empty($search) ? '' : " AND tensanpham LIKE '%$search%'";

// Phân trang
$limit = 30; // Số lượng sản phẩm trên mỗi trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Câu truy vấn
$sql_lietke_sp = "SELECT sp.*, dm.tendanhmuc, mau.id_sanpham_mau, mau.soluongmau, mau.soluongdaban, mau.hinhanh AS hinhanh_mau
                FROM tbl_sanpham sp
                JOIN tbl_danhmuc dm ON sp.id_danhmuc = dm.id_danhmuc
                LEFT JOIN tbl_sanpham_mau mau ON sp.id_sanpham = mau.id_sanpham
                WHERE 1 $condition
                GROUP BY sp.id_sanpham
                ORDER BY sp.id_sanpham DESC
                LIMIT $offset, $limit";
$query_lietke_sp = mysqli_query($mysqli, $sql_lietke_sp);

// Đếm tổng số sản phẩm (cần để tính số trang)
$sql_count = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE 1 $condition";
$result_count = mysqli_query($mysqli, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Tính số trang
$total_pages = ceil($total_records / $limit);
?>
<p>Liệt kê danh mục sản phẩm</p>

<a href="index.php?action=quanlysp&query=them"><button class="btn btn-success" style="margin-top: 10px;;">Thêm Sản Phẩm</button></a>

<form action="index.php" method="get" class="form-inline mt-2 mb-2">
    <input type="hidden" name="action" value="quanlysp">
    <input type="hidden" name="query" value="lietke">
    <input type="hidden" name="page" value="1"> <!-- Để đảm bảo page không bị trống -->
    <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm">
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Giá sp</th>
            <th scope="col">Giá gốc</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Danh mục</th>
            <th scope="col">Mã sp</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Thời gian ra mắt</th>
            <th scope="col">Quản lý</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_sp)) {
            $i++;
        
            // Lấy thông tin từ sản phẩm màu đầu tiên trong danh sách
            $hinhanh_mau = $row['hinhanh_mau'];
            $soluongmau = $row['soluongmau'];
        
            // Nếu có nhiều hơn 1 màu, bạn có thể thay đổi cách lấy hình ảnh và số lượng ở đây
        
            if ($row['giakm'] > 0) {
                $giaspkm = $row['giasp'] - ($row['giasp'] * ($row['giakm'] / 100));
            } else {
                $giaspkm = $row['giasp'];
            }
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['tensanpham'] ?></td>
                <td><img src="modules/quanlysp/uploads/<?php echo $hinhanh_mau ?>" width="200px"></td>
                <td><?php echo number_format($giaspkm, 0, ',', '.') ?></td>
                <td><?php echo number_format($row['giagoc'], 0, ',', '.') ?></td>
                <td><?php echo $soluongmau ?></td>
                <td><?php echo $row['tendanhmuc'] ?></td>
                <td><?php echo $row['masp'] ?></td>
                <td><?php echo ($row['tinhtrang'] == 1) ? 'Kích hoạt' : 'Ẩn'; ?></td>
                <td><?php echo $row['thoigian'] ?></td>
                <td>
                    <a href="modules/quanlysp/xuly.php?idsanpham=<?php echo $row['id_sanpham'] ?>">Xóa</a> |
                    <a href="?action=quanlysp&query=sua&idsanpham=<?php echo $row['id_sanpham'] ?>">Sửa</a>
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
                <a class="page-link" href="index.php?action=quanlysp&query=lietke<?php echo $search; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>