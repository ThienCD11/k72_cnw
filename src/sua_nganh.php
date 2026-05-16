<?php
session_start();
include "../function.php";
include "../connectdb.php";

if (!kiem_tra_dang_nhap()) {
    header("Location: dang_nhap.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_nganh'])) {
    $id_nganh = $_GET['id_nganh'];
    $nganh = sua_nganh($id_nganh);
    $dsKhoi = sua_khoi_theo_nganh($id_nganh);
    if (!$nganh) {
        die("Không tìm thấy ngành học.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id_nganh' => $_POST['id_nganh'],
        'ten_nganh' => $_POST['ten_nganh'],
        'ngay_bat_dau' => $_POST['ngay_bat_dau'],
        'ngay_ket_thuc' => $_POST['ngay_ket_thuc'],
        'khoi_data' => []
    ];

    foreach ($_POST['khoi'] as $khoi) {
        $data['khoi_data'][] = [
            'id_khoi' => $khoi['id_khoi'],
            'ten_khoi' => $khoi['ten_khoi'],
            'mon1' => $khoi['mon1'],
            'mon2' => $khoi['mon2'],
            'mon3' => $khoi['mon3']
        ];
    }

    if (cap_nhat_nganh_va_khoi($data)) {
        header("Location: trang_chu.php");
    } else {
        $error = "Cập nhật thất bại.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>k72_nhom_23</title>
    <link rel="icon" href="../img/nhom_23.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .form {
            background-color: white;
            opacity: 0.95;
            margin: 20px auto;
            width: 500px;
            border: 2px solid darkblue;
            padding: 20px 50px;
            border-radius: 10px;
        }
        .form-group {
            display: flex;
            flex-direction: column; 
            margin-bottom: 15px; 
        }
        .form-group label {
            flex: 1;
            font-weight: bold;
            margin-bottom: 5px; 
        }
        #form-group label {
            flex: 1;
            font-weight: bold;
            margin-bottom: 5px; 
            padding-left: 20px;
        }
        #form-group input,
        .form-group input {
            width: 100%; 
            border-radius: 5px;
            padding: 5px 10px 5px 20px;
            border: 1.5px solid darkblue;
            background: lightblue;
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
    </style>
</head>
<body>
    <!-- Thanh điều hướng -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img id="img" src="../img/hnue.png" alt="HNUE Logo">Trang sửa thông tin</a>
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
    <h2>Sửa thông tin ngành nộp hồ sơ</h2>
</div>

<div class="form">
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="sua_nganh.php">
        <input type="hidden" name="id_nganh" value="<?php echo $nganh['id_nganh']; ?>">
        <div class="form-group">
            <label for="ten_nganh"><h5>Tên Ngành</h5></label>
            <input type="text" id="ten_nganh" name="ten_nganh" value="<?php echo $nganh['ten_nganh']; ?>" required>
        </div>

        <?php foreach ($dsKhoi as $index => $khoi): ?>
            <div class="form-group" id="form-group">
                <h5>Khối Xét Tuyển <?php echo $index + 1; ?></h5>
                <input type="hidden" name="khoi[<?php echo $index; ?>][id_khoi]" value="<?php echo $khoi['id_khoi']; ?>">
                <div class="form-group">
                    <label for="ten_khoi_<?php echo $index; ?>">Tên khối</label>
                    <input type="text" id="ten_khoi_<?php echo $index; ?>" name="khoi[<?php echo $index; ?>][ten_khoi]" value="<?php echo $khoi['ten_khoi']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="mon1_<?php echo $index; ?>">Môn 1</label>
                    <input type="text" id="mon1_<?php echo $index; ?>" name="khoi[<?php echo $index; ?>][mon1]" value="<?php echo $khoi['mon1']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="mon2_<?php echo $index; ?>">Môn 2</label>
                    <input type="text" id="mon2_<?php echo $index; ?>" name="khoi[<?php echo $index; ?>][mon2]" value="<?php echo $khoi['mon2']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="mon3_<?php echo $index; ?>">Môn 3</label>
                    <input type="text" id="mon3_<?php echo $index; ?>" name="khoi[<?php echo $index; ?>][mon3]" value="<?php echo $khoi['mon3']; ?>" required>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label for="ngay_bat_dau"><h5>Ngày Bắt Đầu</h5></label>
            <input type="date" id="ngay_bat_dau" name="ngay_bat_dau" value="<?php echo $nganh['ngay_bat_dau']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ngay_ket_thuc"><h5>Ngày Kết Thúc</h5></label>
            <input type="date" id="ngay_ket_thuc" name="ngay_ket_thuc" value="<?php echo $nganh['ngay_ket_thuc']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
        <a href="trang_chu.php" class="btn btn-secondary">Hủy</a>
    </form>
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
