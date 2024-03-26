<div id="main">
    <?php
    // include("sidebar/sidebar.php");
    ?>

    <div class="maincontent">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = '';
        }
        if ($page == 'sanpham') {
            include("main/sanpham.php");
        } elseif ($page == 'giohang') {
            include("main/giohang.php");
        } elseif ($page == 'tatcasanpham') {
            include("main/tatcasanpham.php");
        } elseif ($page == 'danhmucbaiviet') {
            include("main/danhmucbaiviet.php");
        } elseif ($page == 'baiviet') {
            include("main/baiviet.php");
        } elseif ($page == 'tintuc') {
            include("main/tintuc.php");
        } elseif ($page == 'lienhe') {
            include("main/lienhe.php");
        } elseif ($page == 'sanpham') {
            include("main/sanpham.php");
        } elseif ($page == 'dangky') {
            include("main/dangky.php");
        } elseif ($page == 'thanhtoan') {
            include("main/thanhtoan.php");
        } elseif ($page == 'dangnhap') {
            include("main/dangnhap.php");
        } elseif ($page == 'timkiem') {
            include("main/timkiem.php");
        } elseif ($page == 'camon') {
            include("main/camon.php");
        } elseif ($page == 'thaydoimatkhau') {
            include("main/thaydoimatkhau.php");
        } elseif ($page == 'thongtinthanhtoan') {
            include("main/thongtinthanhtoan.php");
        } elseif ($page == 'donhang') {
            include("main/donhang.php");
        } elseif ($page == 'xemdonhang') {
            include("main/xemdonhang.php");
        } elseif ($page == 'xuly') {
            include("main/xuly.php");
        } elseif ($page == 'ketqua') {
            include("main/ketquathanhtoan.php");
        } elseif ($page == 'xuathoadon') {
            include("./admincp/modules/quanlydonhang/xuathoadon.php");
        } else {
            include("main/index.php");
        }

        ?>
    </div>

</div>