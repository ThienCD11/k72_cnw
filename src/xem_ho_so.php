<?php
session_start();
include "../function.php";
include "../connectdb.php";

// Kiểm tra người dùng đã đăng nhập chưa
if (!kiem_tra_dang_nhap()) {
    header("location: dang_nhap.php");
    exit();
}

// Kiểm tra và lấy thông tin ngành từ session
if (!isset($_SESSION['id_nganh'])) {
    echo "Không có thông tin ngành trong session.";
    exit();
} else {
    $id_nganh = $_SESSION['id_nganh'];
    $vai_tro = $_SESSION['vai_tro'];
    $ten_nganh = lay_ten_nganh($id_nganh); 
    $ds_khoi_xet = lay_khoi_xet_tuyen($id_nganh); 
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>k72_nhom_23</title>
    <link rel="icon" href="../img/nhom_23.png" type="image/png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../img/background.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .navbar {
            background-color: darkblue !important;
        }
        .navbar-light .navbar-nav .nav-link {
            color: white !important; 
        }
        .navbar-light .navbar-nav .nav-link:hover {
            font-weight: bold !important;
        }
        .navbar-light .navbar-brand {
            color: white !important; 
            font-weight: bold;
        }
        .navbar-light .navbar-nav .nav-item.dropdown .dropdown-menu {
            background-color: darkblue !important;
        }
        .navbar-light .navbar-nav .nav-item.dropdown .dropdown-menu .dropdown-item {
            color: white !important;
            background-color: darkblue !important;
        }
        .navbar-light .navbar-nav .nav-item.dropdown .dropdown-menu .dropdown-item:hover {
            background-color: navy !important; 
            color: white !important;
        }
        footer {
            background-color: midnightblue;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .card {
            margin: 20px 0;
            opacity: 0.95;
            border: 1px solid darkblue;
        }
        .hero {
            background-color: royalblue;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .list {
            background-color: white;
            opacity: 0.95;
            width: 95%;
            margin: 20px auto;
            border: 2px solid darkblue;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 300px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid darkblue;
            text-align: left;
            padding-left: 15px;
        }
        th {
            background: dodgerblue;
            padding: 10px;
            color: white;
        }
        td {
            background: lightblue;
            padding: 10px;      
        }
        /* CSS cho các icon logo nhỏ chung */
        img {
            width: 30px;
            border-radius: 50%;
            margin: -10px 10px -5px 10px;
        }
        #img {
            width: 45px;
            border-radius: 50%;
            margin: -5px 20px -5px 10px;
            border: 2px solid white;
        }
        /* CSS riêng hiển thị ảnh học bạ rõ nét không bị bo tròn */
        .img-hocba {
            width: 80px;
            height: auto;
            border-radius: 4px;
            border: 1px solid #004085;
            margin: 0;
            transition: transform 0.2s;
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img id="img" src="../img/hnue.png" alt="HNUE Logo">Trang xem hồ sơ chi tiết</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Xin chào, <?php echo $_SESSION['vai_tro']; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="nop_ho_so.php">Quay lại</a>
                    <a class="dropdown-item" href="trang_chu.php">Quay lại trang chủ</a>
                    <a class="dropdown-item" href="dang_xuat.php" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="hero">
    <h2>Chi tiết hồ sơ xét tuyển đại học</h2>
</div>

<div class="list">
<h3 style='color:darkblue;margin-bottom: 15px;text-align:center'>Danh sách hồ sơ chi tiết của học sinh</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>Họ tên học sinh</th>
            <th>Ngành nộp hồ sơ</th>
            <th>Khối xét hồ sơ</th>
            <th>Điểm môn 1</th>
            <th>Điểm môn 2</th>
            <th>Điểm môn 3</th>
            <th>Ảnh học bạ</th>
        </tr>
        <?php 
        $stt = 1;
        $ds_ho_so = ho_so_chi_tiet($ten_nganh);
        foreach ($ds_ho_so as $ho_so): 
        ?>
        <tr>
            <td><?php echo $stt++; ?></td>
            <td><?php echo $ho_so['ho_ten_hoc_sinh']; ?></td>
            <td><?php echo $ho_so['nganh_nop_ho_so']; ?></td>
            <td><?php echo $ho_so['khoi_xet']; ?></td>
            <td><?php echo $ho_so['diem_mon1']; ?></td>
            <td><?php echo $ho_so['diem_mon2']; ?></td>
            <td><?php echo $ho_so['diem_mon3']; ?></td>
            <td class="text-center">
                <?php
                // Kiểm tra xem trường lưu tên ảnh trong DB có dữ liệu hay không
                // LƯU Ý: Bạn hãy đổi chữ 'anh_hoc_ba' thành tên cột lưu tên ảnh thực tế trong DB của bạn (ví dụ: 'hoc_ba', 'link_anh'...)
                if (!empty($ho_so['hoc_ba'])) {
                    $ten_file_anh = $ho_so['hoc_ba'];
                    
                    // Đường dẫn đi từ file hiện tại tìm đến file ảnh nằm trong thư mục hoc_ba
                    $duong_dan_anh = $ten_file_anh; 
                    
                    // Kiểm tra xem file ảnh có thực sự tồn tại trong thư mục trên máy chủ không
                    if (file_exists($duong_dan_anh)) {
                        echo "<img src='$duong_dan_anh' class='img-hocba' alt='Ảnh học bạ'>";
                        echo "</a>";
                    } else {
                        echo "<span class='text-muted' style='font-size: 12px;'>Không tìm thấy file ảnh gốc</span>";
                    }
                } else {
                    echo "<span class='text-danger' style='font-size: 12px;'>Chưa có ảnh</span>";
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<footer>
    <p><img src="../img/cntt.png" alt="CNTT Logo"> Công nghệ web 2024.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>