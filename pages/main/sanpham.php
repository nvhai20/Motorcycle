<div class="container mt-3">
    
    <?php
    // Assume $_GET['id'] contains the product ID
    $product_id = $_GET['id'];

    $sql_chitiet = "SELECT sp.*, dm.tendanhmuc, mau.id_mau, m.tenmau, mau.hinhanh, mau.soluongmau, mau.soluongdaban
                    FROM tbl_sanpham sp
                    JOIN tbl_danhmuc dm ON sp.id_danhmuc = dm.id_danhmuc
                    LEFT JOIN tbl_sanpham_mau mau ON sp.id_sanpham = mau.id_sanpham
                    LEFT JOIN tbl_mau m ON mau.id_mau = m.id_mau
                    WHERE sp.id_sanpham = $product_id
                    LIMIT 1";

    $query_chitiet = mysqli_query($mysqli, $sql_chitiet);

    // Check if the query was successful
    if ($query_chitiet) {
        while ($row_chitiet = mysqli_fetch_array($query_chitiet)) {
            if ($row_chitiet['giakm'] > 0) {
                $giaspkm = $row_chitiet['giasp'] - ($row_chitiet['giasp'] * ($row_chitiet['giakm'] / 100));
            } else {
                $giaspkm = $row_chitiet['giasp'];
            }
    ?>
    <div class="tieu432">
                <a class="a321" href="index.php">Trang chủ</a> >
            <a class="a321" href="index.php?page=tatcasanpham">Sản phẩm </a> >
            <a class="ten321" href=""><?php echo $row_chitiet['tensanpham'] ?></a>
            </div>
        <div class="wrapper_chitiet">

            <div class="rows">
                <div class="col-md-4s">
                    <!-- Hình ảnh chính -->
                    <div class="main-imagess">
                        <img width="100%" src="admincp/modules/quanlysp/uploads/<?php echo $row_chitiet['hinhanh'] ?>">
                    </div>
                    <!-- Thanh trượt ảnh nhỏ -->
                    <div class="thumbnail-gallery-mt-3">
                        <?php
                        $sql_hinhanh = "SELECT hinhanh, soluongmau, soluongdaban FROM tbl_sanpham_mau WHERE id_sanpham = $product_id";
                        $query_hinhanh = mysqli_query($mysqli, $sql_hinhanh);
                        $tongSoLuong = 0;
                        $sql_tongSoLuong = "SELECT SUM(soluongmau - soluongdaban) AS tongSoLuong FROM tbl_sanpham_mau WHERE id_sanpham = $product_id";
                        $query_tongSoLuong = mysqli_query($mysqli, $sql_tongSoLuong);
                        
                        if ($query_tongSoLuong) {
                            $row_tongSoLuong = mysqli_fetch_assoc($query_tongSoLuong);
                            $tongSoLuong = $row_tongSoLuong['tongSoLuong'];
                        }
                        while ($row_hinhanh = mysqli_fetch_assoc($query_hinhanh)) {
                            ?>
                            <div class="thumbnails" data-soluongmau="<?php echo $row_hinhanh['soluongmau']; ?>"
                                data-soluongdaban="<?php echo $row_hinhanh['soluongdaban']; ?>">
                                <img width="100%" src="admincp/modules/quanlysp/uploads/<?php echo $row_hinhanh['hinhanh']; ?>">
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-8s">
                    <form method="POST" action="pages/main/themgiohang.php?idsanpham=<?php echo $row_chitiet['id_sanpham'] ?>">
                        <div class="chitiet_sanpham">
                            <h3 style="margin:0;   text-transform: uppercase;margin-bottom:10px;"><?php echo $row_chitiet['tensanpham'] ?></h3>
                            <p class="e321ww">Mã : <?php echo $row_chitiet['masp'] ?></p>
   
                            <p class="e321ww">Số lượng :  <?php echo $tongSoLuong; ?></p>
                            <p class="e321ww">Thời gian ra mắt: <?php echo $row_chitiet['thoigian'] ?></p>
                            <div class="colors">
    <?php
    $sql_mau = "SELECT m.*, sm.hinhanh,sm.soluongmau,sm.soluongdaban
                FROM tbl_mau m
                JOIN tbl_sanpham_mau sm ON m.id_mau = sm.id_mau
                WHERE sm.id_sanpham = $product_id";

    $query_mau = mysqli_query($mysqli, $sql_mau);

    $available_colors = 0; // Biến để đếm số màu còn hàng

    while ($row_mau = mysqli_fetch_assoc($query_mau)) {
        $soluongconlai = $row_mau['soluongmau'] - $row_mau['soluongdaban'];

        // Kiểm tra số lượng còn lại
        if ($soluongconlai > 0) {
            $available_colors++; // Tăng số màu còn hàng
        ?>

            <label class="color-label">
                <input type="radio" name="mau" value="<?php echo $row_mau['id_mau']; ?>" 
                    style="display: none;" data-hinhanh="admincp/modules/quanlysp/uploads/<?php echo $row_mau['hinhanh']; ?>">
                <div class="color" style="background-color: <?php echo $row_mau['tenmau']; ?>" title="<?php echo $row_mau['tenmau']; ?>"></div>
            </label>

    <?php
        }
    }

    // Kiểm tra tổng số màu còn lại để xác định sản phẩm có hết hàng hay không
    if ($available_colors == 0) {
        echo "Sản phẩm này đã hết hàng";
    }
    ?>
</div>


                            <div class="ccc321">
                            <p class="mmm321"><?php echo number_format($giaspkm , 0, ',', '.') . ' VND'; ?> </p>

                            <p style="text-decoration: line-through; color:#7d7d7d;font-size:15px;"> <?php echo number_format($row_chitiet['giagoc'], 0, ',', '.') . '' . ' VND' ?> </p>
                            </div>
                            <div class="ksk321"> <p class="kkk321"> <i class='bx bx-gift'></i> Khuyến mãi</p>
                                <div class="cccs321">
                                <p>Mũ bảo hiểm đạt chuẩn 250.000Đ</p>
                                <p>Miễn phí giao xe 30km nội thành</p>
                                </div>
                            </div>
                            <div class="fjfj43"> 
                            <button class="themgiohang" name="themgiohang" type="submit" ><i class='bx bxs-cart'></i> Thêm giỏ hàng
                            <button class="muangay" name="muangay" type="submit" > Mua ngay
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tabs product_detail">
    <ul id="tabs-nav" class="m-0 p-0 d-flex mb-4" style="border-bottom: 2px solid black;">
    <div class="tabs chi_tiet_san_pham">
    <ul id="tabs-nav" class="m-0 p-0 d-flex mb-3" style="border-bottom: 2px solid black;">
        <li class="pr-2 my-2 border-right"><a href="#tom-tat">Thông số kỹ thuật</a></li>
        <li class="pr-2 pl-2 my-2 border-right"><a href="#noi-dung">Nội dung chi tiết</a></li>
        <li class="pr-2 pl-2 my-2 border-right"><a href="#hinh-anh">Hình ảnh sản phẩm</a></li>
    </ul> <!-- END tabs-nav -->
    <div id="tabs-contenta" class="d-flex-flex-wrap"> <!-- Added flex-wrap -->
        <div id="tom-tat" class="tab-content-col-md-4"> <!-- Set width for summary -->
            <?php echo $row_chitiet['tomtat'] ?>
        </div>

        <div id="noi-dung" class="tab-content-col-md-8"> <!-- Set width for content -->
            <?php echo $row_chitiet['noidung'] ?>
        </div>

        <div id="hinh-anh" class="tab-content-col-12 mt-3"> <!-- Full-width for images -->
            <!-- Display image based on color variation -->
            <div class="row">
    <?php
    $sql_hinhanh = "SELECT hinhanh FROM tbl_sanpham_mau WHERE id_sanpham = $product_id";
    $query_hinhanh = mysqli_query($mysqli, $sql_hinhanh);
    while ($row_hinhanh = mysqli_fetch_assoc($query_hinhanh)) {
    ?>
    <div class="col-md-3">
        <img width='100%' src='admincp/modules/quanlysp/uploads/<?php echo $row_hinhanh['hinhanh']; ?>' alt='Hình ảnh sản phẩm'>
    </div>
    <?php
    }
    ?>
</div>
        </div>
    </div> <!-- END tabs-content -->
</div> <!-- END tabs -->


        <style>
    .thumbnails img {
        border: 1px solid #ddd; /* Viền mặc định cho ảnh nhỏ */
        cursor: pointer;
    }

    .thumbnails img.selected {
        border: 2px solid #4CAF50; /* Viền xanh cho ảnh nhỏ đã chọn */
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var thumbnails = document.querySelectorAll('.thumbnails img');
    var mainImage = document.querySelector('.main-imagess img');

    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            var imagePath = this.getAttribute('src');
            var soluongmau = this.parentElement.getAttribute('data-soluongmau');
            var soluongdaban = this.parentElement.getAttribute('data-soluongdaban');

            // Adjust quantity based on available stock
            var adjustedQuantity = soluongmau - soluongdaban;
            if (adjustedQuantity > 0) {
                // Set the main image source
                mainImage.setAttribute('src', imagePath);

                // Remove the "selected" class from all thumbnails
                thumbnails.forEach(function(thumb) {
                    thumb.classList.remove('selected');
                });

                // Add the "selected" class to the clicked thumbnail
                this.classList.add('selected');
            } else {
                alert('Out of stock for this color variation.');
            }
        });
    });

    // Lấy danh sách tất cả các input radio trong nhóm "mau"
    var radioButtons = document.querySelectorAll('input[name="mau"]');

    // Thêm sự kiện change cho các radio buttons
    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Lấy ảnh từ thuộc tính data-hinhanh của radio button được chọn
            var selectedImage = this.getAttribute('data-hinhanh');
            
            // Set ảnh chính với ảnh mới
            mainImage.setAttribute('src', selectedImage);
        });
    });
});

</script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
    // Lấy danh sách tất cả các input radio trong nhóm "mau"
    var radioButtons = document.querySelectorAll('input[name="mau"]');

    // Kiểm tra nếu có ít nhất một input radio
    if (radioButtons.length > 0) {
        // Đặt thuộc tính checked cho input radio đầu tiên
        radioButtons[0].checked = true;
    }
});

        </script>

    <?php
        }
    } else {
        // Handle the case where the query fails
        echo "Error fetching product details: " . mysqli_error($mysqli);
    }
    ?>
</div>


