<?php
session_start();
include "../function.php";
include "../connectdb.php";

// Kiểm tra người dùng đã đăng nhập chưa
if (!kiem_tra_dang_nhap()) {
    header("location: dang_nhap.php");
    exit();
}
if (!kiem_tra_dang_nhap() || $_SESSION['vai_tro'] !== 'admin') {
    header("location: trang_chu.php");
    exit();
}
if (isset($_POST['xoa_nguoi_dung'])) {
    $id_nguoi_dung = $_POST['xoa_nguoi_dung'];
    if (xoa_nguoi_dung($id_nguoi_dung)) {
        header("Location: tai_khoan.php");
    } else {
        echo "Lỗi khi xóa hồ sơ.";
    }
}
$ds_tai_khoan = lay_tai_khoan();
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
            margin-bottom: 200px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid darkblue;
            text-align: center;
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
        img {
            width: 30px;
            border-radius: 50%;
            margin: -10 10 -5 10px;
        }
        #img {
            width: 45px;
            border-radius: 50%;
            margin: -5px 20px -5px 10px;
            border: 2px solid white;
        }
        #a {
            padding-left: 50px;
            text-align: left;
        }
    </style>
</head>
<body>
<!-- Thanh điều hướng -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img id="img" src="../img/hnue.png" alt="HNUE Logo">Trang thống kê tài khoản</a>
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
                    <a class="dropdown-item" href="trang_chu.php">Quay lại trang chủ</a>
                    <a class="dropdown-item" href="dang_xuat.php" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="hero">
    <h2>Thống kê tài khoản đã đăng ký</h2>
</div>

<div class="list">
<h3 style='color:darkblue;margin-bottom: 15px;text-align:center'>Số lượng tài khoản đã đăng ký</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>Tài khoản</th>
            <th>Mật khẩu</th>
            <th>Vai trò</th>
            <th>Xóa</th>
        </tr>
        <?php
        $stt = 1;
        foreach ($ds_tai_khoan as $tai_khoan) {
            // Kiểm tra nếu vai trò là admin, giaovien, hoc sinh thì không có nút xóa
            $khong_xoa = in_array($tai_khoan['tai_khoan'], ['admin', 'giaovien', 'hocsinh']) ? 'disabled' : '';
        ?>
            <tr>
                <td><?php echo $stt++; ?></td>
                <td><?php echo $tai_khoan['tai_khoan']; ?></td>
                <td><?php echo $tai_khoan['mat_khau']; ?></td>
                <td><?php echo $tai_khoan['vai_tro']; ?></td>
                <td>
                    <?php if ($khong_xoa): ?>
                        <button class="btn btn-danger" <?php echo $khong_xoa; ?>>Xóa</button>
                        <?php else: ?>
                        <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                            <input type="hidden" name="xoa_nguoi_dung" value="<?php echo $tai_khoan['id_nguoi_dung']; ?>">
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- Chân trang -->
<footer>
    <p><img src="../img/cntt.png" alt="CNTT Logo"> Công nghệ web 2024.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
