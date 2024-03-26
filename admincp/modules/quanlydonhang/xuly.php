<?php
	include('../../config/config.php');
    $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
    $nowDateString = new DateTime('now', $timezone);
    $now = $nowDateString->format('Y-m-d');
    
    if(isset($_GET['code']) && isset($_GET['status'])){
        $code_cart = $_GET['code'];
        $status = $_GET['status'];
    
        // Cập nhật trạng thái cart_status trong cơ sở dữ liệu
        if($status == 'moi'){
            $sql_update = "UPDATE tbl_donhang SET cart_status = 1 WHERE code_cart = '$code_cart'";
    
        } elseif($status == 'chuanbi'){
            $sql_update = "UPDATE tbl_donhang SET cart_status = 2 WHERE code_cart = '$code_cart'";
    } elseif($status == 'danggiao'){
            $sql_update = "UPDATE tbl_donhang SET cart_status = 3 WHERE code_cart = '$code_cart'";
        }
		$query = mysqli_query($mysqli,$sql_update);

		//thong ke doanh thu
       // Lấy danh sách sản phẩm trong đơn hàng hiện tại
       $sql_lietke_dh = "SELECT * FROM tbl_cart_details, tbl_sanpham WHERE tbl_cart_details.id_sanpham = tbl_sanpham.id_sanpham AND tbl_cart_details.code_cart = '$code_cart' ORDER BY tbl_cart_details.id_cart_details DESC";
       $query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);
       
       // Khởi tạo các biến thống kê
       $soluongmua = 0;
       $doanhthu = 0;
       $gianhap = 0;
       
       // Tính toán tổng số lượng mua, doanh thu và giá nhập từ danh sách sản phẩm trong đơn hàng
 
       header('Location:../../index.php?action=quanlydonhang&query=lietke');

       // Lấy ngày hiện tại
     
	} else {
        $id = $_GET['idcart'];
    
        // Xóa dữ liệu từ tbl_cart và tbl_cart_details sử dụng DELETE JOIN
        $sql_xoa = "DELETE tbl_cart_details, tbl_donhang
        FROM tbl_donhang
        LEFT JOIN tbl_cart_details ON tbl_donhang.code_cart = tbl_cart_details.code_cart
        WHERE tbl_donhang.code_cart = '".$id."'";
        ;
    
        mysqli_query($mysqli, $sql_xoa);
    
        header('Location:../../index.php?action=quanlydonhang&query=lietke');
    }
?>