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
    <a class="navbar-brand" href="#"><img id="img" src="../img/hnue.png" alt="HNUE Logo">Trang thống kê hồ sơ</a>
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
                    <a class="dropdown-item" href="dang_xuat.php">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="hero">
    <h2>Thống kê hồ sơ xét tuyển đại học</h2>
</div>

<div class="list">
<h3 style='color:darkblue;margin-bottom: 15px;text-align:center'>Số lượng hồ sơ của học sinh đã nộp</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>Ngành nộp hồ sơ</th>
            <th>Hồ sơ chưa duyệt</th>
            <th>Hồ sơ đã duyệt</th>
            <th>Hồ sơ không duyệt</th>
        </tr>
        <?php
        $stt = 1;
        $thong_ke = thong_ke_ho_so();
        foreach ($thong_ke as $row) {
            echo "<tr>";
            echo "<td>". $stt++ . "</td>";
            echo "<td id='a'>" . htmlspecialchars($row['nganh_nop_ho_so']) . "</td>";
            echo "<td>" . htmlspecialchars($row['chua_duyet']) . "</td>";
            echo "<td>" . htmlspecialchars($row['da_duyet']) . "</td>";
            echo "<td>" . htmlspecialchars($row['khong_duyet']) . "</td>";
            echo "</tr>";
        }
        ?>
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
