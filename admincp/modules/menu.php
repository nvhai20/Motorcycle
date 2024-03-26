
<ul style="list-style:none;" class="m-0 p-0">
<li <?php echo (isset($_GET['action']) && $_GET["action"] == 'dashboard' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=dashboard&query=lietke">Dashboard</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlydanhmucsanpham' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlydanhmucsanpham&query=them">Quản lý danh mục sản phẩm</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlythuonghieu' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlythuonghieu&query=them">Quản lý thương hiệu</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlysp' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlysp&query=lietke">Quản lý sản phẩm</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlydanhmucbaiviet' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlydanhmucbaiviet&query=them">Quản lý danh mục bài viết</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlybaiviet' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlybaiviet&query=lietke">Quản lý bài viết</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlydonhang' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlydonhang&query=lietke">Quản lý đơn hàng</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlyweb' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlyweb&query=capnhat">Quản lý web</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlyweb' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlyslide&query=lietke">Quản lý ảnh bìa</a></li>
    <li <?php echo (isset($_GET['action']) && $_GET["action"] == 'quanlyweb' ? 'class="active"' : '') ?>><a class="d-block my-1 py-3" href="index.php?action=quanlykho&query=lietke">Quản lý kho</a></li>

</ul>
