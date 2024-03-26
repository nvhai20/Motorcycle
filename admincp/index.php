<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ob_start(); // Bắt đầu bộ đệm đầu ra
session_start();
if (!isset($_SESSION['dangnhap'])) {
}

if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    unset($_SESSION['dangnhap']);
    header("Location:../index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css
" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Admin</title>

    <style>
        body {
            background: #fafafa;
        }

        p {
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            color: #999;
        }

        a,
        a:hover,
        a:focus {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            margin-bottom: 40px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-btn {
            box-shadow: none;
            outline: none !important;
            border: none;
        }

        .line {
            width: 100%;
            height: 1px;
            border-bottom: 1px dashed #ddd;
            margin: 40px 0;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #7386D5;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #6d7fcc;
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #47748b;
        }

        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
        }

        #sidebar ul li a:hover {
            color: #7386D5;
            background: #fff;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: black;
            background: white;
        }

        a[data-toggle="collapse"] {
            position: relative;
        }

        ul ul a {
            font-size: 0.9em !important;
            padding-left: 30px !important;
            background: #6d7fcc;
        }

        a.download {
            background: #fff;
            color: #7386D5;
        }

        a.article,
        a.article:hover {
            background: #6d7fcc !important;
            color: #fff !important;
        }

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #sidebarCollapse span {
                display: none;
            }
        }

        table input {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    include("config/config.php");
    ?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>GoBike</h3>
            </div>

            <ul class="list-unstyled components">
                <?php
                include("modules/menu.php");
                ?>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Hello  <?php  if(isset($_SESSION['dangky'])){echo ($_SESSION['dangky']);} ?> !
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="?dangxuat=1">Đăng xuất</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php
            include("modules/main.php");
            ?>

        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js
"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js
"></script>
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js
"></script>
    <script>
        CKEDITOR.replace('thongtinlienhe');
        CKEDITOR.replace('tomtat');
        CKEDITOR.replace('noidung');
    </script>
</body>

</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
 <script>

    </script>
<script type="text/javascript">
    $(document).ready(function(){
        thongke();
        var char = new Morris.Area({
            element: 'chart',
            xkey: 'date',
            ykeys: ['donhang', 'doanhthu', 'gianhap', 'soluong', 'loinhuan'],
            labels: ['Đơn hàng', 'Doanh thu', 'Giá nhập', 'Số lượng đã bán', 'Lợi Nhuận']
        });

        $('.select-date').change(function(){
            var thoigian = $(this).val();
            var text = getLabelText(thoigian);

            // Thay đổi nhãn của biểu đồ dựa trên lựa chọn từ dropdown
            char.options.labels = getChartLabels(thoigian);

            $.ajax({
                url:"modules/thongke.php",
                method:"POST",
                dataType:"JSON",
                data:{thoigian:thoigian},
                success:function(data)
                {
                    char.setData(data);
                    $('#text-date').text(text);
                    updateOtherInfo(data); // Hàm cập nhật thông tin khác
                }   
            });
        });

        function thongke(){
            var text = '365 ngày qua';
            $('#text-date').text(text);
            $.ajax({
                url:"modules/thongke.php",
                method:"POST",
                dataType:"JSON",
                success:function(data)
                {
                    char.setData(data);
                    $('#text-date').text(text);
                    updateOtherInfo(data); // Hàm cập nhật thông tin khác
                }   
            });
        }

        function getLabelText(thoigian) {
            if(thoigian=='7ngay'){
                return '7 ngày qua';
            } else if(thoigian=='28ngay'){
                return '28 ngày qua';
            } else if(thoigian=='90ngay'){
                return '90 ngày qua';
            } else {
                return '365 ngày qua';
            }
        }

        function getChartLabels(thoigian) {
            // Trả về các nhãn tương ứng với lựa chọn từ dropdown
            if (thoigian == '7ngay') {
                return ['Đơn hàng', 'Doanh thu', 'Giá nhập', 'Số lượng đã bán', 'Lợi Nhuận'];
            } else if (thoigian == '28ngay') {
                return ['Đơn hàng', 'Doanh thu', 'Giá nhập', 'Số lượng đã bán', 'Lợi Nhuận'];
            } else if (thoigian == '90ngay') {
                return ['Đơn hàng', 'Doanh thu', 'Giá nhập', 'Số lượng đã bán', 'Lợi Nhuận'];
            } else {
                return ['Đơn hàng', 'Doanh thu', 'Giá nhập', 'Số lượng đã bán', 'Lợi Nhuận'];
            }
        }

        function updateOtherInfo(data) {
            // Cập nhật thông tin khác dựa trên dữ liệu mới từ Ajax
            $('#total-orders').text(data.total_orders);
            $('#total-sales').text(data.total_sales);
            $('#total-cost').text(data.total_cost);
            $('#total-quantity').text(data.total_quantity);
            $('#total-profit').text(data.total_profit);
        }
    });
</script>
<?php ob_end_flush(); ?>