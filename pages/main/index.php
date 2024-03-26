<div style="min-height:100vh;">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $sql = "SELECT * FROM tbl_slide ORDER BY thutu ASC";
        $query = mysqli_query($mysqli, $sql);
        $active = 'active';

        while ($row = mysqli_fetch_array($query)) {
        ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $row['thutu'] - 1; ?>" class="<?php echo $active; ?>"></li>
        <?php
            $active = '';
        }
        ?>
    </ol>

    <div class="carousel-inner" role="listbox">
        <?php
        $query = mysqli_query($mysqli, $sql);
        $active = 'active';

        while ($row = mysqli_fetch_array($query)) {
        ?>
            <div class="carousel-item <?php echo $active; ?>">
                <img class="d-block w-100" src="admincp/modules/quanlyslide/uploads/<?php echo $row['hinhanh']; ?>" alt="Slide Image">
                <!-- Add any additional content or captions here -->
            </div>
        <?php
            $active = '';
        }
        ?>
    </div>

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

    <div id="newArtical">
        <?php
        $sql = "SELECT * FROM tbl_baiviet ORDER BY id DESC LIMIT 4";
        $query_bv = mysqli_query($mysqli, $sql);
        ?>

        <div class="container">
            <div style="background-color:#FAF0E6;" class="p-2 rounded d-flex justify-content-between my-4">
                <span>Bài viết mới nhất</span>
                <a href="index.php?page=tintuc">Tất cả bài viết >>></a>
            </div>
            <div class="row">
                <?php
                while ($row_bv = mysqli_fetch_array($query_bv)) {
                ?>
                    <div class="col-md-3">
                        <img style="object-fit: cover; width:100%; height:200px;" src="admincp/modules/quanlybaiviet/uploads/<?php echo $row_bv['hinhanh'] ?>">
                        <a class="my-2 text-overfl-2line" href=" index.php?page=baiviet&id=<?php echo $row_bv['id'] ?>">
                            <?php echo $row_bv['tenbaiviet'] ?>
                        </a>
                        <span class="m-0 text-overfl-3line"><?php echo $row_bv['tomtat'] ?></span>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

<div class="container">
    <div style="background-color:#FAF0E6;" class="p-2 rounded d-flex justify-content-between my-4">
        <span>Sản phẩm mới nhất</span>
        <a href="index.php?page=tatcasanpham">Tất cả sản phẩm >>></a>
    </div>
    <div class="rows">
        <?php
        $sql_pro = "SELECT * FROM tbl_sanpham ORDER BY id_sanpham DESC LIMIT 20";
        $query_pro = mysqli_query($mysqli, $sql_pro);
        
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
                <div class="discount-percentage"><?php echo $row_pro['giakm'] . '%' ?></div>

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
                                <p class="m-02"><?php echo number_format($row_pro['giagoc'], 0, ',', '.') . "" . '₫' ?> </p>
                                <p class="m-01"><?php echo number_format($giaspkm, 0, ',', '.') . '₫' ?></p>
                            <?php
                            } else {
                            ?>
                                <p class="m-0"><?php echo number_format($row_pro['giagoc'], 0, ',', '.') . "" . '₫' ?></p>
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



</div>