<?php
    session_start();
    include "../function.php";
    include "../connectdb.php";

    if (!kiem_tra_dang_nhap()) {
        header("location: dang_nhap.php");
        exit();
    }
    if (isset($_POST['nop_ho_so'])) {
        $id_nganh = $_POST['id_nganh']; // Lấy id_nganh từ POST
        if (!empty($id_nganh)) { // Kiểm tra id_nganh có tồn tại
            $_SESSION['id_nganh'] = $id_nganh; // Lưu vào SESSION
            $_SESSION['id_hoc_sinh'] = $id_hoc_sinh; 
            header("Location: nop_ho_so.php"); // Chuyển hướng sau khi lưu
            exit();
        } else {
            echo "Không tìm thấy ID ngành!";
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_nganh = $_POST['id_nganh'];
        if (isset($_POST['hide'])) {
            $action = 'hide';
        } elseif (isset($_POST['show'])) {
            $action = 'show';
        } else {
            $action = null;
        }
        if ($action) {
            if (cap_nhat_an_hien($id_nganh, $action)) {
            } else {
                echo 'Không thể cập nhật trạng thái ngành học.';
            }
        }
    }

    $role = $_SESSION['vai_tro'];
    $result = an_hien_nop_ho_so($role);

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
        .btn-primary:hover {
            background-color: darkblue !important;
            border-color: navy !important;
            transition: 0.3s;
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
            opacity: 0.9;
            border: 1px solid darkblue;
            transition: transform 0.15s, opacity 0.15s, border-width 0.15s; /* Thêm hiệu ứng chuyển động */
            border-width: 1px;
        }
        .card:hover {
            transform: scale(1.05); /* Phóng to thẻ khi hover */
            opacity: 1; /* Tăng độ mờ */
            border-width: 2px; /* Tăng độ dày của viền */
        }
        .hero {
            background-color: royalblue;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        #nop {
            background-color: royalblue;
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
    <a class="navbar-brand" href="#"><img id="img" src="../img/hnue.png" alt="HNUE Logo">Trang chủ</a>
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
                    <a class="dropdown-item" href="thong_ke.php">Thống kê hồ sơ</a>
                    <a class="dropdown-item" href="tai_khoan.php">Thống kê tài khoản</a>
                    <a class="dropdown-item" href="dang_xuat.php" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- Danh Sách Khóa Học -->
<div class="hero">
    <h2>Danh sách các ngành xét tuyển hồ sơ học bạ</h2>
</div>

<div class="container content">
    <div class="row">
    <?php
    $ds_nganh = danh_sach_nganh();
    if (empty($ds_nganh)) {
        echo "<p>Không có ngành nào.</p>";
    } else {
        foreach ($ds_nganh as $nganh) {
            ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $nganh['ten_nganh']; ?></h3>
                        <h5 class="card-title">Khối xét tuyển: 
                            <?php echo implode(', ', $nganh['khoi_xet_tuyen']); ?>
                        </h5>
                        <h6 class="card-title">Thời gian: 
                            <?php echo date("d/m/Y", strtotime($nganh['ngay_bat_dau'])); ?> - 
                            <?php echo date("d/m/Y", strtotime($nganh['ngay_ket_thuc'])); ?>
                        </h6>

                        <form method="post" action="" style="display:inline;">
                            <?php if ($role == 'admin'): ?>
                                <!-- Nút Nộp hồ sơ -->
                                <input type="hidden" name="id_nganh" value="<?php echo $nganh['id_nganh']; ?>">
                                <button type="submit" name="nop_ho_so" class="btn btn-primary" 
                                        onclick="return confirm('Bạn có chắc chắn muốn nộp hồ sơ?')">Nộp hồ sơ</button>

                                <!-- Nút Ẩn/Hiện -->
                                <input type="hidden" name="id_nganh" value="<?php echo $nganh['id_nganh']; ?>">
                                <?php if ($nganh['an_hien'] == 'hiện'): ?>
                                    <button type="submit" name="hide" class="btn btn-warning">Ẩn</button>
                                <?php else: ?>
                                    <button type="submit" name="show" class="btn btn-success">Hiện</button>
                                <?php endif; ?>

                                <!-- Nút Sửa -->
                                <a href="sua_nganh.php?id_nganh=<?php echo $nganh['id_nganh']; ?>" class="btn btn-secondary">Sửa</a>
                            <?php endif; ?>

                            <?php if ($role == 'học sinh' || $role == 'giáo viên') : ?>
                                <!-- Nộp hồ sơ hiển thị -->
                                <?php if ($nganh['an_hien'] == 'hiện') : ?>
                                    <input type="hidden" name="id_nganh" value="<?php echo $nganh['id_nganh']; ?>">
                                    <button type="submit" name="nop_ho_so" class="btn btn-primary" 
                                            onclick="return confirm('Bạn có chắc chắn muốn nộp hồ sơ?')">Nộp hồ sơ</button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
    </div>
</div>

<!-- Chân trang -->
<footer>
    <p><img src="../img/cntt.png" alt="CNTT Logo">  Công nghệ web 2024.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Các script JavaScript tương tác -->
<!-- <script>
    // Hiệu ứng mờ và phóng to khi di chuột vào các thẻ ngành học
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.05)';
            card.style.opacity = '1';
            card.style.borderWidth = '2px';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1)';
            card.style.opacity = '0.9';
            card.style.borderWidth = '1px';
        });
    });
</script> -->
</body>
</html>
