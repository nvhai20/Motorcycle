<?php
include('../../config/config.php');

if (isset($_POST['themsanpham'])) {
    // Các biến POST
    $tensanpham = $_POST['tensanpham'];
    $masp = $_POST['masp'];
    $giasp = $_POST['giasp'];
    $giagoc = $_POST['giagoc'];
    $giakm = $_POST['giakm'];
    $mauArray = $_POST['mau'];
    $tongsoluong = $_POST['tongsoluong'];
    $tomtat = $_POST['tomtat'];
    $noidung = $_POST['noidung'];
    $tinhtrang = $_POST['tinhtrang'];
    $thoigian = $_POST['thoigian'];
    $danhmuc = $_POST['danhmuc'];
    $thuonghieu = $_POST['thuonghieu'];
    $soluongmauArray = json_decode($_POST['soluongmau'], true);

    // Thêm sản phẩm vào bảng tbl_sanpham
    $sql_them = "INSERT INTO tbl_sanpham (tensanpham, masp, giasp, giagoc, giakm, tomtat, noidung, tinhtrang, thoigian, id_danhmuc, id_thuonghieu) 
                 VALUES ('$tensanpham', '$masp', '$giasp', '$giagoc', '$giakm', '$tomtat', '$noidung', '$tinhtrang', '$thoigian', '$danhmuc', '$thuonghieu')";

if ($mysqli->query($sql_them)) {
    $lastInsertedId = $mysqli->insert_id; // Lấy ID của sản phẩm vừa thêm vào

    // Xử lý các hình ảnh màu sắc
    if (isset($_FILES['hinhanhmau']) && count($_FILES['hinhanhmau']['name']) > 0) {
        
        // Mảng lưu trữ các hình ảnh đã được xử lý để không xử lý lặp lại
        $processedImages = array();
        
        foreach ($mauArray as $mauid) { // Sử dụng mảng mauArray để lấy id_mau
            if (isset($_FILES['hinhanhmau']['name'][$mauid]) && !isset($processedImages[$mauid])) {
                $file_name = $_FILES['hinhanhmau']['name'][$mauid];
                $file_tmp = $_FILES['hinhanhmau']['tmp_name'][$mauid];
                $file_error = $_FILES['hinhanhmau']['error'][$mauid];
                $file_size = $_FILES['hinhanhmau']['size'][$mauid];
                
                // Số lượng màu sắc từ soluongmauArray
                $soluongmau = $soluongmauArray[$mauid];

                if ($file_error == UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/';
                    $file_path = $upload_dir . $file_name;
                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $sql_them_mau = "INSERT INTO tbl_sanpham_mau (id_sanpham, id_mau, soluongmau, hinhanh) 
                                              VALUES ('$lastInsertedId', '$mauid', '$soluongmau', '$file_name')";
                        $mysqli->query($sql_them_mau);
                        // Ghi nhận rằng hình ảnh của màu này đã được xử lý
                        $processedImages[$mauid] = true;
                    } else {
                        echo "Lỗi khi tải file màu $mauid.";
                    }
                } else {
                    echo "Lỗi khi tải file màu $mauid: " . $file_error;
                }
            } else {
                echo "Không tìm thấy file cho màu $mauid hoặc file đã được xử lý.";
            }
        }
    } else {
        echo "Không có hình ảnh nào được tải lên hoặc có lỗi xảy ra.";
    }
} else {
    echo "Có lỗi khi thêm sản phẩm vào cơ sở dữ liệu: " . $mysqli->error;
}
echo '<script>alert("Thêm sản phẩm thành công!");window.location = window.history.go(-1);</script>';

}





elseif (isset($_POST['suasanpham'])) {
    // Sửa sản phẩm
    $id_sanpham = $_GET['idsanpham'];
    $giakm = $_POST['giakm'];
    $thuonghieu = $_POST['thuonghieu'];
    $tensanpham = $_POST['tensanpham'];
    $masp = $_POST['masp'];
    $giasp = $_POST['giasp'];
    $giagoc = $_POST['giagoc'];
    $tongsoluong = $_POST['tongsoluong'];
    $tomtat = $_POST['tomtat'];
    $noidung = $_POST['noidung'];
    $tinhtrang = $_POST['tinhtrang'];
    $danhmuc = $_POST['danhmuc'];
    $thoigian = $_POST['thoigian'];
    $soluongmauArray = json_decode($_POST['soluongmau'], true); // Decode mảng số lượng màu từ dữ liệu POST

    // Cập nhật thông tin chính của sản phẩm
    $sql_update = "UPDATE tbl_sanpham SET giakm='$giakm', id_thuonghieu='$thuonghieu', tensanpham='$tensanpham', masp='$masp', giasp='$giasp', giagoc='$giagoc', tomtat='$tomtat', noidung='$noidung', tinhtrang='$tinhtrang', id_danhmuc='$danhmuc', thoigian='$thoigian' WHERE id_sanpham='$id_sanpham'";
    mysqli_query($mysqli, $sql_update);

    // Xóa các thông tin cũ về số lượng và hình ảnh của sản phẩm từ bảng tbl_sanpham_mau
    $sql_delete_old_mau = "DELETE FROM tbl_sanpham_mau WHERE id_sanpham='$id_sanpham'";
    mysqli_query($mysqli, $sql_delete_old_mau);

    // Thêm thông tin mới về số lượng và hình ảnh của sản phẩm vào bảng tbl_sanpham_mau
    foreach ($soluongmauArray as $mauid => $soluongmau) {
        // Biến cờ để kiểm tra xem có ảnh mới được tải lên hay không
        $hasNewImage = false;
    
        // Kiểm tra xem có ảnh mới được tải lên cho màu này không
        if (isset($_FILES['hinhanhmau']['name'][$mauid]) && !empty($_FILES['hinhanhmau']['name'][$mauid])) {
            $hasNewImage = true;
            $hinhanh_name = $_FILES['hinhanhmau']['name'][$mauid];
            $hinhanh_tmp = $_FILES['hinhanhmau']['tmp_name'][$mauid];
            $hinhanh_error = $_FILES['hinhanhmau']['error'][$mauid];
    
            if ($hinhanh_error == UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/';
                $hinhanh_path = $upload_dir . $hinhanh_name;
    
                if (move_uploaded_file($hinhanh_tmp, $hinhanh_path)) {
                    // Nếu tải ảnh mới thành công, thêm thông tin vào bảng tbl_sanpham_mau
                    $sql_insert_mau = "INSERT INTO tbl_sanpham_mau (id_sanpham, id_mau, soluongmau, hinhanh) 
                                       VALUES ('$id_sanpham', '$mauid', '$soluongmau', '$hinhanh_name')";
                    mysqli_query($mysqli, $sql_insert_mau);
                } else {
                    echo "Lỗi khi tải ảnh mới cho màu có ID $mauid.";
                }
            } else {
                echo "Lỗi khi tải ảnh mới cho màu có ID $mauid: " . $hinhanh_error;
            }
        }
    
        // Nếu không có ảnh mới được tải lên, chỉ cập nhật thông tin về số lượng màu
        if (!$hasNewImage) {
            $sql_insert_mau = "INSERT INTO tbl_sanpham_mau (id_sanpham, id_mau, soluongmau) 
                               VALUES ('$id_sanpham', '$mauid', '$soluongmau')";
            mysqli_query($mysqli, $sql_insert_mau);
        }
    }
    
    

    // Thông báo thành công và chuyển hướng trở lại trang trước đó
    echo '<script>alert("Sửa sản phẩm thành công!");window.location = window.history.go(-1);</script>';
}
 else {
    // Xóa sản phẩm
    $id_sanpham = $_GET['idsanpham'];

    // Xóa hình ảnh
    $sql_select_image = "SELECT hinhanh FROM tbl_sanpham WHERE id_sanpham='$id_sanpham'";
    $result_image = mysqli_query($mysqli, $sql_select_image);
    $row_image = mysqli_fetch_assoc($result_image);
    $image_path = 'uploads/' . $row_image['hinhanh'];
    unlink($image_path);

    // Xóa các bản ghi liên quan trong bảng tbl_sanpham_mau
    $sql_delete_mau = "DELETE FROM tbl_sanpham_mau WHERE id_sanpham='$id_sanpham'";
    mysqli_query($mysqli, $sql_delete_mau);

    // Xóa sản phẩm trong bảng tbl_sanpham
    $sql_delete = "DELETE FROM tbl_sanpham WHERE id_sanpham='$id_sanpham'";
    mysqli_query($mysqli, $sql_delete);

    header('Location:../../index.php?action=quanlysp&query=them');
}
?>
