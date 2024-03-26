<div class="clear"></div>
<div class="main">
    <?php
    if (isset($_GET['action']) && $_GET['query']) {
        $page = $_GET['action'];
        $query = $_GET['query'];
    } else {
        $page = '';
        $query = '';
    }
    if ($page == 'quanlydanhmucsanpham' && $query == 'them') {
        include("modules/quanlydanhmucsp/them.php");
        include("modules/quanlydanhmucsp/lietke.php");
    } elseif ($page == 'quanlydanhmucsanpham' && $query == 'sua') {
        include("modules/quanlydanhmucsp/sua.php");
    } elseif ($page == 'quanlythuonghieu' && $query == 'them') {
        include("modules/quanlythuonghieu/them.php");
        include("modules/quanlythuonghieu/lietke.php");
    } elseif ($page == 'quanlythuonghieu' && $query == 'sua') {
        include("modules/quanlythuonghieu/sua.php");
    } elseif ($page == 'quanlysp' && $query == 'lietke') {
        include("modules/quanlysp/lietke.php");
    } elseif ($page == 'quanlysp' && $query == 'them') {
        include("modules/quanlysp/them.php");
    } elseif ($page == 'quanlysp' && $query == 'sua') {
        include("modules/quanlysp/sua.php");
    } elseif ($page == 'quanlydonhang' && $query == 'lietke') {
        include("modules/quanlydonhang/lietke.php");
    } elseif ($page == 'quanlydonhang' && $query == 'xuly') {
        include("modules/quanlydonhang/xuly.php");

    } elseif ($page == 'donhang' && $query == 'xemdonhang') {
        include("modules/quanlydonhang/xemdonhang.php");
    } elseif ($page == 'donhang' && $query == 'xuathoadon') {
        include("modules/quanlydonhang/xuathoadon.php");
    } elseif ($page == 'quanlydanhmucbaiviet' && $query == 'them') {
        include("modules/quanlydanhmucbaiviet/them.php");
        include("modules/quanlydanhmucbaiviet/lietke.php");
    } elseif ($page == 'quanlydanhmucbaiviet' && $query == 'sua') {
        include("modules/quanlydanhmucbaiviet/sua.php");
    } elseif ($page == 'quanlybaiviet' && $query == 'lietke') {
        include("modules/quanlybaiviet/lietke.php");
    } elseif ($page == 'quanlybaiviet' && $query == 'them') {
        include("modules/quanlybaiviet/them.php");
    } elseif ($page == 'quanlybaiviet' && $query == 'sua') {
        include("modules/quanlybaiviet/sua.php");
    } elseif ($page == 'quanlyweb' && $query == 'capnhat') {
        include("modules/thongtinweb/quanly.php");
    }elseif($page=='quanlythanhvien' && $query =='lietke'){
        include("modules/quanlythanhvien/lietke.php");
    }elseif($page=='quanlythanhvien' && $query =='sua'){
        include("modules/quanlythanhvien/sua.php");       
    }elseif($page=='quanlythanhvien' && $query =='them'){
        include("modules/quanlythanhvien/them.php");

    }elseif($page=='quanlyslide' && $query =='lietke'){
        include("modules/quanlyslide/lietke.php");
    }elseif($page=='quanlyslide' && $query =='sua'){
        include("modules/quanlyslide/sua.php");
    }elseif($page=='quanlyslide' && $query =='xuly'){
        include("modules/quanlyslide/xuly.php");
    }elseif($page=='dashboard' && $query =='lietke'){
        include("modules/dashboard.php");
        
    }elseif($page=='quanlykho' && $query =='lietke'){
        include("modules/quanlykho/lietke.php");
    }

    // else{
    //     include("modules/dashboard.php");
    // }
    ob_end_flush();
    ?>
</div>