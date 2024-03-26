<?php
if (isset($_POST['timkiem'])) {
    $tukhoa = $_POST['tukhoa'];
}
$sql_pro = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.tensanpham LIKE'%" . $tukhoa . "%'";
$query_pro = mysqli_query($mysqli, $sql_pro);

?>
<div class="container" style="min-height: 100vh;">
    <p class="my-2">Từ khóa tìm kiếm: <?php echo $_POST['tukhoa'] ?></p>
    <div class="rows">
        <?php
        
        if (!$query_pro) {
            die('Query Error: ' . mysqli_error($mysqli));
        }
        while ($row_pro = mysqli_fetch_array($query_pro)) {
            if ($row_pro['giakm'] > 0) {
                $giaspkm = $row_pro['giasp'] - ($row_pro['giasp'] * ($row_pro['giakm'] / 100));
            } else {
                $giaspkm = $row_pro['giasp'];
            }
            ?>
            <div class='acv321'>
                <div>
                <?php
        // Thêm điều kiện kiểm tra giakm > 0 trước khi hiển thị discount percentage
        if ($row_pro['giakm'] > 0) {
            echo "<div class='discount-percentage'>" . $row_pro['giakm'] . '%' . "</div>";
        }
        ?>
                    <?php
                    // Thực hiện truy vấn để lấy thông tin từ bảng tbl_sanpham_mau
                    $id_sanpham = $row_pro['id_sanpham'];
                    $sql_sanpham_mau = "SELECT * FROM tbl_sanpham_mau WHERE id_sanpham = $id_sanpham LIMIT 1";
                    $query_sanpham_mau = mysqli_query($mysqli, $sql_sanpham_mau);

                    if (!$query_sanpham_mau) {
                        die('Query Error: ' . mysqli_error($mysqli));
                    }

                    $row_sanpham_mau = mysqli_fetch_assoc($query_sanpham_mau);

                    // Kiểm tra xem có hình ảnh trong tbl_sanpham_mau không
                    $hinhanh = (!empty($row_sanpham_mau['hinhanh'])) ? $row_sanpham_mau['hinhanh'] : $row_pro['hinhanh'];
                    ?>
                    <a href="index.php?page=sanpham&id=<?php echo $row_pro['id_sanpham'] ?>" class="text-center">
                        <img class="img312" src="admincp/modules/quanlysp/uploads/<?php echo $hinhanh ?>">
                    </a>
                </div>
                <div class="mt-3">
                    <div class="d-flex flex-column align-items-center " style="min-height:130px;">
                        <div class="px-2 text-center">
                            <a class="text-overfl-2line" href="index.php?page=sanpham&id=<?php echo $row_pro['id_sanpham'] ?>" class="m-0"><?php echo $row_pro['tensanpham'] ?></a>
                        </div>
                        <div class="text-centers">
                            <?php
                            if (!empty($row_pro['giasp'])) {
                            ?>
                                <p class="m-02"><?php echo number_format($row_pro['giagoc'], 0, ',', '.') . ".000" . '₫' ?> </p>
                                <p class="m-01"><?php echo number_format($giaspkm, 0, ',', '.') . '₫' ?></p>
                            <?php
                            } else {
                            ?>
                                <p class="m-0"><?php echo number_format($row_pro['giagoc'], 0, ',', '.') . ".000" . '₫' ?></p>
                            <?php
                            }
                            ?>
                        </div>
                        <div>
                            <button class="btn btn-primary my-2">
                                <a href="index.php?page=sanpham&id=<?php echo $row_pro['id_sanpham'] ?>" class="text-white">Xem chi tiết</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>