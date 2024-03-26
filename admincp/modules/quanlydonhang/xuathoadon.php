<?php

// Tải thư viện FPDF
require_once('xuathoadon/fpdf.php');

// Hàm chuyển đổi chuỗi có dấu sang không dấu
function removeVietnameseAccents($str) {
    $str = str_replace(
        array('á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
        $str
    );

    $str = str_replace(
        array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'),
        array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),
        $str
    );

    $str = str_replace(
        array('í', 'ì', 'ỉ', 'ĩ', 'ị'),
        array('i', 'i', 'i', 'i', 'i'),
        $str
    );

    $str = str_replace(
        array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'),
        array('o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'),
        $str
    );

    $str = str_replace(
        array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'),
        array('u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u'),
        $str
    );

    $str = str_replace(
        array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'),
        array('y', 'y', 'y', 'y', 'y'),
        $str
    );

    return $str;
}

// Lấy mã code từ tham số truyền vào
$code = isset($_GET['code']) ? $_GET['code'] : '';

// Thực hiện truy vấn SQL để lấy thông tin đơn hàng
// Replace 'your_table_name' bằng tên thực tế của bảng chứa thông tin đơn hàng
$sql = "
    SELECT
        dh.tenkhachhang AS TenKhachHang,
        dh.payment_method AS thanhtoan,

        dh.dienthoai AS SoDienThoai,
        dh.diachi AS DiaChi,
        sp.tensanpham AS TenSanPham,
        cd.soluongmua AS SoLuongMua,
        m.tenmau AS MauSac,
        (cd.soluongmua * sp.giasp * (100 - sp.giakm) / 100) AS SoTien
    FROM
        tbl_donhang dh
    INNER JOIN
        tbl_cart_details cd ON dh.code_cart = cd.code_cart
    INNER JOIN
        tbl_sanpham sp ON cd.id_sanpham = sp.id_sanpham
    INNER JOIN
        tbl_mau m ON cd.mau = m.id_mau
    WHERE
        dh.code_cart = '$code';
";

// Thực hiện kết nối và truy vấn SQL (Dưới đây là ví dụ, bạn cần thay đổi thông tin kết nối dựa trên môi trường của bạn)
$result = $mysqli->query($sql);

// Tạo đối tượng PDF
$pdf = new FPDF();
$pdf->AddPage();
// Đặt font chữ hỗ trợ tiếng Việt (Arial Unicode MS)
$pdf->SetFont('Arial', '', 12);

// Thêm tiêu đề "Hóa đơn"
$pdf->Cell(0, 10, removeVietnameseAccents('HOA DON'), 0, 1, 'C');

// Xử lý kết quả truy vấn và thêm thông tin vào PDF
if ($result->num_rows > 0) {
    // Lưu giữ tất cả dữ liệu vào một mảng
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    // Thêm thông tin đơn vị bán hàng
    $pdf->Cell(0, 10, removeVietnameseAccents('DON VI BAN HANG: Gobike'), 0, 1);
    $pdf->Cell(0, 10, removeVietnameseAccents('DIA CHI: Tây Tựu, Hà Nội'), 0, 1);
    $pdf->Cell(0, 10, removeVietnameseAccents('SDT: 0123456789'), 0, 1);
    $pdf->Cell(0, 10, removeVietnameseAccents('STK: 0123456789000 - BIDV'), 0, 1);
    $pdf->Ln(10); // or $pdf->Ln();
    
    // Thêm thông tin người mua hàng (lấy thông tin từ dòng đầu tiên)
    $pdf->Cell(0, 10, removeVietnameseAccents('Ho ten nguoi mua hang: ' . $data[0]['TenKhachHang']), 0, 1);
    $pdf->Cell(0, 10, removeVietnameseAccents('SDT: ' . $data[0]['SoDienThoai']), 0, 1);
    $pdf->Cell(0, 10, removeVietnameseAccents('Dia chi: ' . $data[0]['DiaChi']), 0, 1);
    $pdf->Cell(0, 10, removeVietnameseAccents('Hinh thuc thanh toan: ' . $data[0]['thanhtoan']), 0, 1);
    
    // Add space or line break here
    $pdf->Ln(10); // or $pdf->Ln();
    
    // Thêm bảng chi tiết đơn hàng
    $pdf->Cell(10, 10, 'STT', 1);
    $pdf->Cell(50, 10, removeVietnameseAccents('Ten hang hoa'), 1);
    $pdf->Cell(30, 10, removeVietnameseAccents('So luong'), 1);
    $pdf->Cell(30, 10, removeVietnameseAccents('Mau sac'), 1);
    $pdf->Cell(40, 10, removeVietnameseAccents('Thanh tien'), 1);
    $pdf->Ln(); // Xuống dòng
    
    $stt = 1;
    $totalAmount = 0;
    foreach ($data as $row) {
        $pdf->Cell(10, 10, $stt++, 1);
        $pdf->Cell(50, 10, removeVietnameseAccents($row['TenSanPham']), 1);
        $pdf->Cell(30, 10, removeVietnameseAccents($row['SoLuongMua']), 1);
        $pdf->Cell(30, 10, removeVietnameseAccents($row['MauSac']), 1);
    
        // Định dạng số và hiển thị giá trị
        $formattedAmount = number_format($row['SoTien']);
        $pdf->Cell(40, 10, removeVietnameseAccents($formattedAmount), 1);
    
        $pdf->Ln(); // Xuống dòng
    
        // Cộng dồn vào biến tổng tiền
        $totalAmount += $row['SoTien'];
    }
    
    // Định dạng số cho tổng tiền và hiển thị
    $formattedTotalAmount = number_format($totalAmount);
    // Tổng tiền
    $pdf->Cell(120, 10, removeVietnameseAccents('Tong tien'), 1);
    $pdf->Cell(40, 10, removeVietnameseAccents($formattedTotalAmount), 1);
    $pdf->Ln(); // Xuống dòng

    // Người mua hàng (chữ ký)
    $pdf->Cell(90, 10, removeVietnameseAccents('Nguoi mua hang (chu ky)'), 0);
    $pdf->Cell(0, 10, removeVietnameseAccents('Don vi ban hang (chu ky)'), 0, 1);
} else {
    // Hiển thị thông báo nếu không tìm thấy đơn hàng
    $pdf->Cell(0, 10, removeVietnameseAccents('Khong tim thay thong tin don hang'), 0, 1);
}
ob_clean(); // Xóa bỏ bất kỳ đầu ra nào đã được tạo ra
// Xuất PDF ra trình duyệt
$pdf->Output('order_invoice.pdf', 'D');
?>
