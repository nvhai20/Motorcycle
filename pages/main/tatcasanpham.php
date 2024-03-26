<?php

if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = '1';
}

$itemsPerPage = 16;
$begin = ($page - 1) * $itemsPerPage;

$current_category = 'all';
$current_branch = 'all';

if (isset($_GET['danhmuc'])) {
    $current_category = $_GET['danhmuc'];
}

if (isset($_GET['thuonghieu'])) {
    $current_branch = $_GET['thuonghieu'];
}

$whereConditions = [];

if ($current_category != 'all') {
    $whereConditions[] = "tbl_sanpham.id_danhmuc = '$current_category'";
}

if ($current_branch != 'all') {
    $whereConditions[] = "tbl_sanpham.id_thuonghieu = '$current_branch'";
}

$whereClause = (!empty($whereConditions)) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

$sql_pro = "SELECT * FROM tbl_sanpham $whereClause ORDER BY id_sanpham DESC LIMIT $begin, $itemsPerPage";
$sql_trang = "SELECT * FROM tbl_sanpham $whereClause";

$query_pro = mysqli_query($mysqli, $sql_pro);
$query_trang = mysqli_query($mysqli, $sql_trang);

if (!$query_pro || !$query_trang) {
    die('Query Error: ' . mysqli_error($mysqli));
}

$row_count = mysqli_num_rows($query_trang);
$trang = ceil($row_count / $itemsPerPage);

?>
<div class="container my-3">
    <div class="row">
        <div class="col-3">
            <!-- <ul class="list-group">
                <li class="list-group-item disabled text-center text-white mb-1" style="background-color: black;">Danh mục sản phẩm</li>
                <li <?php echo ($current_category == 'all') ?  "style='background:#f0f0f0;'" : ""; ?> class="list-group-item p-0">
                    <a class="text-dark d-block py-2 px-3" href="index.php?page=tatcasanpham&danhmuc=all<?php echo ($current_branch != 'all') ? "&thuonghieu=" . $current_branch : ''; ?>">Tất cả sản phẩm</a>
                </li>
                <?php
                $sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
                $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                while ($row = mysqli_fetch_array($query_danhmuc)) {
                ?>
                    <li <?php echo ($current_category == $row['id_danhmuc']) ?  "style='background:#f0f0f0;'" : ""; ?> class="list-group-item p-0">
                        <a class="text-dark d-block py-2 px-3" href="index.php?page=tatcasanpham&danhmuc=<?php echo $row['id_danhmuc'] ?><?php echo ($current_branch != 'all') ? "&thuonghieu=" . $current_branch : ''; ?>">
                            <?php echo $row['tendanhmuc'] ?>
                        </a>
                    </li>
                <?php
                }
                ?>
 -->
                <ul class="list-group mt-4">
                    <li class="list-group-item disabled text-center text-white mb-1" style="background-color: black;">Thương hiệu</li>
                    <li <?php echo ($current_branch == 'all') ?  "style='background:#f0f0f0;'" : ""; ?> class="list-group-item p-0">
                        <a class="text-dark d-block py-2 px-3" href="index.php?page=tatcasanpham<?php echo ($current_category != 'all') ? "&danhmuc=" . $current_category : ''; ?>&thuonghieu=all">Tất cả thương hiệu</a>
                    </li>
                    <?php
                    $sql_thuonghieu = "SELECT * FROM tbl_thuonghieu ORDER BY id_thuonghieu DESC";
                    $query_thuonghieu = mysqli_query($mysqli, $sql_thuonghieu);
                    while ($row = mysqli_fetch_array($query_thuonghieu)) {
                    ?>
                        <li <?php echo ($current_branch == $row['id_thuonghieu']) ?  "style='background:#f0f0f0;'" : ""; ?> class="list-group-item p-0">
                            <a class="text-dark d-block py-2 px-3" href="index.php?page=tatcasanpham<?php echo ($current_category != 'all') ? "&danhmuc=" . $current_category : ''; ?>&thuonghieu=<?php echo $row['id_thuonghieu'] ?>"><?php echo $row['tenthuonghieu'] ?></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
        </div>
        <div class="col-9">
            <div>
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
            <div class="my-5 ">
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php
                        for ($i = 1; $i <= $trang; $i++) {
                        ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : "" ?>">
                                <a class="page-link" href="index.php?page=tatcasanpham<?php echo ($current_category != 'all') ? "&danhmuc=" . $current_category : ''; ?><?php echo ($current_branch != 'all') ? '&thuonghieu=' . $current_branch : ''; ?>&trang=<?php echo $i ?>"><?php echo $i ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>