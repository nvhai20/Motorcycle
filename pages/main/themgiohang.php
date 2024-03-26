<?php
session_start();
include('../../admincp/config/config.php');
//them so luong
// Increase quantity
if (isset($_GET['cong'])) {
    $id = $_GET['cong'];
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $id) {
            $cart_item['soluong'] += 1;
        }
    }
    header('Location:../../index.php?page=giohang');
    exit;
}

// Decrease quantity
if (isset($_GET['tru'])) {
    $id = $_GET['tru'];
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $id && $cart_item['soluong'] > 1) {
            $cart_item['soluong'] -= 1;
        }
    }
    header('Location:../../index.php?page=giohang');
    exit;
}

// Remove item
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    foreach ($_SESSION['cart'] as $key => $cart_item) {
        if ($cart_item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }
    header('Location:../../index.php?page=giohang');
    exit;
}

// Remove all items
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['cart']);
    header('Location:../../index.php?page=giohang');
    exit;
}
//them san pham vao gio hang
if (isset($_POST['themgiohang'])) {
    $id = $_GET['idsanpham'];
    $soluong = 1;

    // Kiểm tra xem 'mau' đã tồn tại trong $_POST không
    if (isset($_POST['mau'])) {
        $id_mau = $_POST['mau'];

        // Truy vấn dữ liệu từ tbl_sanpham và tbl_sanpham_mau dựa trên id_sanpham và id_mau
        $sql = "SELECT sp.*, sm.hinhanh
                FROM tbl_sanpham sp
                JOIN tbl_sanpham_mau sm ON sp.id_sanpham = sm.id_sanpham
                WHERE sp.id_sanpham = '$id' AND sm.id_mau = '$id_mau'
                LIMIT 1";

        $query = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($query);
        $gia_sp = $row['giasp'];
        $giamgia_percent = $row['giakm'];

        // Tính giá sau khi giảm giá
        $giasp_giamgia = $gia_sp - ($gia_sp * ($giamgia_percent / 100));

        if ($row) {
            // Khởi tạo một mảng trống
            $new_product = array();

            // Kiểm tra xem khóa 'hinhanh' có tồn tại trong mảng $row không
            if (isset($row['hinhanh'])) {
                $new_product['hinhanh'] = $row['hinhanh'];
            }

            // Thêm các khóa khác tương tự (nếu cần)
            $new_product['tensanpham'] = $row['tensanpham'];
            $new_product['id'] = $id;
            $new_product['soluong'] = $soluong;
            $new_product['giasp'] = $giasp_giamgia;
            $new_product['masp'] = $row['masp'];
            $new_product['mau'] = $id_mau;

            // Kiểm tra xem session 'cart' có tồn tại không
            if (isset($_SESSION['cart'])) {
                $found = false;

                foreach ($_SESSION['cart'] as &$cart_item) {
                    if ($cart_item['id'] == $id && $cart_item['mau'] == $id_mau) {
                        $cart_item['soluong'] += 1;
                        $found = true;
                    }
                }

                if (!$found) {
                    // Thêm sản phẩm mới vào giỏ hàng đã tồn tại
                    $_SESSION['cart'][] = $new_product;
                }
            } else {
                // Tạo một giỏ hàng mới với sản phẩm mới
                $_SESSION['cart'] = array($new_product);
            }
        }
    }


    // Hiển thị thông tin về session
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();

    }
    if (isset($_POST['muangay'])) {
        $id = $_GET['idsanpham'];
        $soluong = 1;
    
        // Kiểm tra xem 'mau' đã tồn tại trong $_POST không
        if (isset($_POST['mau'])) {
            $id_mau = $_POST['mau'];
    
            // Truy vấn dữ liệu từ tbl_sanpham và tbl_sanpham_mau dựa trên id_sanpham và id_mau
            $sql = "SELECT sp.*, sm.hinhanh
                    FROM tbl_sanpham sp
                    JOIN tbl_sanpham_mau sm ON sp.id_sanpham = sm.id_sanpham
                    WHERE sp.id_sanpham = '$id' AND sm.id_mau = '$id_mau'
                    LIMIT 1";
    
            $query = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_array($query);
            $gia_sp = $row['giasp'];
            $giamgia_percent = $row['giakm'];
    
            // Tính giá sau khi giảm giá
            $giasp_giamgia = $gia_sp - ($gia_sp * ($giamgia_percent / 100));
    
            if ($row) {
                // Khởi tạo một mảng trống
                $new_product = array();
    
                // Kiểm tra xem khóa 'hinhanh' có tồn tại trong mảng $row không
                if (isset($row['hinhanh'])) {
                    $new_product['hinhanh'] = $row['hinhanh'];
                }
    
                // Thêm các khóa khác tương tự (nếu cần)
                $new_product['tensanpham'] = $row['tensanpham'];
                $new_product['id'] = $id;
                $new_product['soluong'] = $soluong;
                $new_product['giasp'] = $giasp_giamgia;
                $new_product['masp'] = $row['masp'];
                $new_product['mau'] = $id_mau;
    
                // Kiểm tra xem session 'cart' có tồn tại không
                if (isset($_SESSION['cart'])) {
                    $found = false;
    
                    foreach ($_SESSION['cart'] as &$cart_item) {
                        if ($cart_item['id'] == $id && $cart_item['mau'] == $id_mau) {
                            $cart_item['soluong'] += 1;
                            $found = true;
                        }
                    }
    
                    if (!$found) {
                        // Thêm sản phẩm mới vào giỏ hàng đã tồn tại
                        $_SESSION['cart'][] = $new_product;
                    }
                } else {
                    // Tạo một giỏ hàng mới với sản phẩm mới
                    $_SESSION['cart'] = array($new_product);
                }
            }
        }
    
    
        // Hiển thị thông tin về session
        header('Location:../../index.php?page=giohang');
        exit();
    }