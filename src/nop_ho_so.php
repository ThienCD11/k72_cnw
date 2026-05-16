<?php
session_start();
include "../function.php";
include "../connectdb.php";

if (!kiem_tra_dang_nhap()) {
    header("location: dang_nhap.php");
    exit();
}

// Kiểm tra và lấy thông tin ngành từ session
if (!isset($_SESSION['id_nganh'])) {
    // echo "Không có thông tin ngành trong session.";
    // exit();
} else {
    $id_nganh = $_SESSION['id_nganh'];
    // $ho_ten_hoc_sinh = $_SESSION['ho_ten_hoc_sinh'];
    // $id_nganh = $_SESSION['id_hoc_sinh'];
    $vai_tro = $_SESSION['vai_tro'];
    $ten_nganh = lay_ten_nganh($id_nganh); 
    $ds_khoi_xet = lay_khoi_xet_tuyen($id_nganh); 
}

if (isset($_POST['action'], $_POST['id_ho_so'])) {
    $id_hoc_sinh = $_POST['id_ho_so'];
    $action = $_POST['action'];

    if ($action === 'duyet' && isset($_POST['trang_thai'], $_POST['nguoi_duyet'])) {
        $trang_thai = $_POST['trang_thai'];
        $nguoi_duyet = $_POST['nguoi_duyet'];

        if (cap_nhat_trang_thai($conn, $id_hoc_sinh, $trang_thai, $nguoi_duyet)) {
            header("Location: nop_ho_so.php");
            exit;
        } else {
            echo "Lỗi khi cập nhật trạng thái.";
        }
    } elseif ($action === 'khong_duyet' && isset($_POST['trang_thai'], $_POST['nguoi_duyet'])) {
        $trang_thai = $_POST['trang_thai'];
        $nguoi_duyet = $_POST['nguoi_duyet'];

        if (cap_nhat_trang_thai($conn, $id_hoc_sinh, $trang_thai, $nguoi_duyet)) {
            header("Location: nop_ho_so.php");
            exit;
        } else {
            echo "Lỗi khi cập nhật trạng thái.";
        }
    } elseif ($action === 'xoa') {
        if (xoa_ho_so($id_hoc_sinh)) {
            header("Location: nop_ho_so.php");
            exit;
        } else {
            echo "Lỗi khi xóa hồ sơ.";
        }
    } else {
        echo "Hành động không hợp lệ.";
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
        #nop {
            background-color: royalblue;
        } 
        .ntt {
            color: darkblue;
            text-align: center;
            font-weight: bold;
            margin: 15px 20px;
            font-size: 30px;
        }
        .form {
            background-color: white;
            opacity: 0.95;
            margin: 20px auto;
            width: 500px;
            border: 2px solid darkblue;
            padding: 0px 20px 10px 20px;
            border-radius: 10px;
        }
        .form-group span {
            margin-right: 30px;
            margin-top: -5px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            font-weight: bold;
            font-size: 18px;
        }
        .form-group label {
            margin-right: 20px;
            flex: 2;
            text-align: left;
        }
        .form-group input {
            flex: 2;
            border-radius: 5px;
            padding-left: 5px;
            border: 1.5px solid darkblue;
            background: lightblue;
            margin-top: -10px;
        }
        .form-group select {
            flex: 2;
            border-radius: 5px;
            padding-left: 10px;
            height: 32px;
            border: 1.5px solid darkblue;
            background: lightblue;
            max-width: 220px;
            margin-top: -10px;
        }
        .form-group input[type="text"] {
            padding-left: 10px;
            width: 50%;
        }
        .form-group input[type="number"] {
            padding-left: 10px;
            width: 50%;
        }
        .form-group input[type="file"] {
            padding: 0px;
            max-width: 250px;
        }
        .form button {
            font-weight: bold;
            margin: 0px 110px 10px 110px;
            width: 50%;
            height: 40px;
            background: lightblue;
            border: 1.5px solid darkblue;
            border-radius: 5px;
        }
        .form button:hover {
            border: 1.5px solid black;
            background: darkblue;
            color: white;
        }
        .tb {
            background: pink;
            text-align: center;
            border: 1.5px solid red;
            border-radius: 5px;
            color: red;
            font-weight: bold;
            padding: 5px;
            margin: 10px;
        }
        .tbtc {
            background: lightgreen;
            text-align: center;
            border: 1.5px solid green;
            border-radius: 5px;
            color: green;
            font-weight: bold;
            padding: 5px;
            margin: 10px;
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
        .xem {
            color: white;
            padding: 2 10px 5 10px;
            background: dodgerblue;
            border: 1px solid darkblue;
            border-radius: 5px;
        }
        .xem:hover {
            border: 1px solid black;
            background: darkblue;
        }
        .duyet {
            color: white;
            padding: 2 10px 5 10px;
            background: limegreen;
            border: 1px solid darkgreen;
            border-radius: 5px;
        }
        .duyet:hover {
            border: 1px solid black;
            background: darkgreen;
        }
        .khong_duyet {
            color: white;
            padding: 2 10px 5 10px;
            background: gold;
            border: 1px solid #976D00;
            border-radius: 5px;
        }
        .khong_duyet:hover {
            border: 1px solid black;
            background: #976D00;
        }
        .xoa {
            color: white;
            padding: 2 10px 5 10px;
            background: red;
            border: 1px solid darkred;
            border-radius: 5px;
        }
        .xoa:hover {
            border: 1px solid black;
            background: darkred;
        }
    </style>
</head>
<body>
<!-- Thanh điều hướng -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img id="img" src="../img/hnue.png" alt="HNUE Logo">Trang nộp hồ sơ chi tiết</a>
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
    <h2>Đăng ký hồ sơ xét tuyển đại học</h2>
</div>

<?php if ($_SESSION['vai_tro'] == 'học sinh'): ?>
<form action="nop_ho_so.php" method="POST" enctype="multipart/form-data">
    <div class="form">
        <div class="ntt">Nhập thông tin</div>
        <div class="form-group">
            <label for="nganh">Ngành bạn đã chọn:</label>
            <span name="nganh"><?php echo htmlspecialchars($ten_nganh); ?></span>
        </div>
        <div class="form-group">
            <label for="ho_ten">Họ và Tên học sinh:</label>
            <input type="text" name="ho_ten" id="ho_ten" placeholder="Nhập họ và tên" value="<?php echo isset($_POST['ho_ten']) ? htmlspecialchars($_POST['ho_ten']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="khoi_xet">Chọn khối xét tuyển:</label>
            <select id="khoi_xet" name="khoi_xet" onchange="updateMonHoc()">
                <option value="">--- Chọn khối ---</option>
                <?php foreach ($ds_khoi_xet as $khoi) { ?>
                    <option value="<?php echo $khoi['ten_khoi']; ?>" 
                        <?php echo isset($_POST['khoi_xet']) && $_POST['khoi_xet'] == $khoi['ten_khoi'] ? 'selected' : ''; ?>
                        ten_mon1="<?php echo $khoi['mon1']; ?>" 
                        ten_mon2="<?php echo $khoi['mon2']; ?>" 
                        ten_mon3="<?php echo $khoi['mon3']; ?>">
                        <?php echo $khoi['ten_khoi']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <!-- Phần nhập điểm -->
        <div class="form-group">
            <label for="mon1">Nhập điểm môn 1:</label>
            <input type="number" name="diem1" id="mon1" step="0.01" min="0" max="10" placeholder="Điểm môn 1" disabled value="<?php echo isset($_POST['diem1']) ? htmlspecialchars($_POST['diem1']) : ''; ?>" required>
            <input type="hidden" name="mon1" id="hidden_mon1"> <!-- Input ẩn lưu tên môn 1 -->
        </div>
        <div class="form-group">
            <label for="mon2">Nhập điểm môn 2:</label>
            <input type="number" name="diem2" id="mon2" step="0.01" min="0" max="10" placeholder="Điểm môn 2" disabled value="<?php echo isset($_POST['diem2']) ? htmlspecialchars($_POST['diem2']) : ''; ?>" required>
            <input type="hidden" name="mon2" id="hidden_mon2"> <!-- Input ẩn lưu tên môn 2 -->
        </div>
        <div class="form-group">
            <label for="mon3">Nhập điểm môn 3:</label>
            <input type="number" name="diem3" id="mon3" step="0.01" min="0" max="10" placeholder="Điểm môn 3" disabled value="<?php echo isset($_POST['diem3']) ? htmlspecialchars($_POST['diem3']) : ''; ?>" required>
            <input type="hidden" name="mon3" id="hidden_mon3"> <!-- Input ẩn lưu tên môn 3 -->
        </div>
        <div class="form-group">
            <label for="hoc_ba" class="file">Tải ảnh học bạ:</label>
            <input type="file" name="hoc_ba" id="hoc_ba" required>
        </div>
        <button type="submit" name="submit" id="submit" onclick="return confirm('Bạn không thể sửa hồ sơ sau khi nộp!')">Nộp hồ sơ</button> 
        <?php
        if (isset($_POST['submit'])) {
            // Lấy dữ liệu từ form
            $ho_ten = $_POST['ho_ten'];
            $khoi_xet = $_POST['khoi_xet'];
            $diem1 = $_POST['diem1'];
            $diem2 = $_POST['diem2'];
            $diem3 = $_POST['diem3'];
            $mon1 = $_POST['mon1'];
            $mon2 = $_POST['mon2'];
            $mon3 = $_POST['mon3'];
            $file = $_FILES['hoc_ba'];
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $coLoiXayRa = false;
        
            // Kiểm tra thời gian nộp hồ sơ
            if (!kiem_tra_thoi_gian($ten_nganh)) {
                echo "<div class='tb'>Hết thời gian nộp hồ sơ cho ngành $ten_nganh!</div>";
                $coLoiXayRa = true;
            }

            // Kiểm tra học sinh đã nộp hồ sơ cho ngành chưa
            if (kiem_tra_nop_ho_so($ho_ten, $ten_nganh)) {
                echo "<div class='tb'>Bạn đã nộp hồ sơ cho ngành $ten_nganh rồi!</div>";
                $coLoiXayRa = true;
            }
        
            // Xử lý file upload
            $file = $_FILES['hoc_ba'];
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $formattedDate = date('Ymd_His');  // Lấy ngày giờ dạng Ymd_His
            $newFileName = $formattedDate . '.' . $fileExtension;
        
            // Kiểm tra và lưu file
            if (in_array($fileExtension, ['jpg', 'png']) && $fileSize < 100 * 1024 * 1024) { //file <100MB
                if (move_uploaded_file($fileTmp, "../hoc_ba/" . $newFileName)) {
                    $hoc_ba_path = "../hoc_ba/" . $newFileName;
                } else {
                    echo "<div class='tb'>Lỗi khi upload file học bạ</div>";
                    $coLoiXayRa = true;
                }
            } else {
                echo "<div class='tb'>Chỉ cho phép file .jpg, .png và dung lượng < 100MB</div>";
                $coLoiXayRa = true;
            }
        
            // Thêm thông tin vào CSDL
            if (!$coLoiXayRa) {
                $result = them_ho_so($ho_ten, $ten_nganh, $khoi_xet, $mon1, $diem1, $mon2, $diem2, $mon3, $diem3, $hoc_ba_path);
                if ($result) {
                    echo "<div class='tbtc'>Nộp hồ sơ thành công!</div>";
                } else {
                    echo "<div class='tb'>Lỗi khi nộp hồ sơ!</div>";
                }
            }
        }        
        ?>
    </div>
</form>
<?php endif; ?>

<div class="list">
<h3 style='color:darkblue;margin-bottom: 15px;text-align:center'>Danh sách hồ sơ của học sinh đã nộp</h3>
    <table>
        <tr>
            <th>STT</th>
            <th>Họ tên học sinh</th>
            <!-- <th>Ngành nộp hồ sơ</th> -->
            <!-- <th>Khối xét hồ sơ</th> -->
            <th>Người duyệt</th>
            <th>Trạng thái</th>
            <th> 
                <?php if ($vai_tro === 'học sinh'): ?>
                    Xem chi tiết
                <?php endif; ?>
                <?php if ($vai_tro === 'admin' || $vai_tro === 'giáo viên'): ?>
                    Hanh động
                <?php endif; ?>
            </th>
            <?php if ($vai_tro === 'admin'): ?> 
                <th>Xóa hồ sơ</th>
            <?php endif; ?>        
        </tr>
        <?php 
        $stt = 1;
        $ds_ho_so = lay_ho_so($ten_nganh);
        foreach ($ds_ho_so as $ho_so): 
        ?>
        <tr>
            <td><?php echo $stt++; ?></td>
            <td><?php echo $ho_so['ho_ten_hoc_sinh']; ?></td>
            <!-- <td><?php echo $ho_so['nganh_nop_ho_so']; ?></td> -->
            <!-- <td><?php echo $ho_so['khoi_xet']; ?></td> -->
            <td><?php echo $ho_so['nguoi_duyet']; ?></td>
            <td><?php echo $ho_so['trang_thai']; ?></td>
            <td>
                <?php if ($vai_tro === 'học sinh'): ?>
                <form action="xem_ho_so.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_ho_so" value="<?php echo $ho_so['id_hoc_sinh']; ?>">
                    <button type="submit" class="xem">Xem chi tiết</button>
                </form>
                <?php endif; ?>
                <?php if ($vai_tro === 'admin' || $vai_tro === 'giáo viên'): ?>
                <form action="xem_ho_so.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_ho_so" value="<?php echo $ho_so['id_hoc_sinh']; ?>">
                    <button type="submit" class="xem">Xem</button>
                </form>
                <form action="nop_ho_so.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_ho_so" value="<?php echo $ho_so['id_hoc_sinh']; ?>">
                    <input type="hidden" name="trang_thai" value="đã duyệt">
                    <input type="hidden" name="nguoi_duyet" value="<?php echo $vai_tro; ?>">
                    <input type="hidden" name="action" value="duyet">
                    <button type="submit" class="duyet">Duyệt</button>
                </form>
                <form action="nop_ho_so.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_ho_so" value="<?php echo $ho_so['id_hoc_sinh']; ?>">
                    <input type="hidden" name="trang_thai" value="không duyệt">
                    <input type="hidden" name="nguoi_duyet" value="<?php echo $vai_tro; ?>">
                    <input type="hidden" name="action" value="khong_duyet">
                    <button type="submit" class="khong_duyet">Không duyệt</button>
                </form>
                <?php endif; ?>  
            </td>
            <?php if ($vai_tro === 'admin'): ?>
                <td>
                    <form action="nop_ho_so.php" method="POST" style="margin: 0;">
                        <input type="hidden" name="id_ho_so" value="<?php echo $ho_so['id_hoc_sinh']; ?>">
                        <input type="hidden" name="action" value="xoa">
                        <button type="submit" class="xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa hồ sơ này?')">Xóa hồ sơ</button>
                    </form>
                </td>
            <?php endif; ?>        
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- Chân trang -->
<footer>
    <p><img src="../img/cntt.png" alt="CNTT Logo"> Công nghệ web 2024.</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function updateMonHoc() {
    const chonKhoi = document.getElementById("khoi_xet");
    const optionKhoi = chonKhoi.options[chonKhoi.selectedIndex];
    const khongChonKhoi = !optionKhoi.value; // Kiểm tra xem có chọn khối chưa

    // Duyệt qua các môn học để cập nhật
    ["mon1", "mon2", "mon3"].forEach((monId, index) => {
        const label = document.querySelector(`label[for="${monId}"]`);
        const input = document.getElementById(monId);
        const hiddenInput = document.getElementById(`hidden_${monId}`);
        const tenMon = khongChonKhoi ? `${index + 1}` : optionKhoi.getAttribute(`ten_mon${index + 1}`);

        // Cập nhật label và input
        label.textContent = `Nhập điểm môn ${tenMon}:`;
        hiddenInput.value = tenMon;
        input.disabled = khongChonKhoi;

        // Nếu chưa chọn khối, xóa giá trị của input
        if (khongChonKhoi) input.value = "";
    });
}

</script>
</body>
</html>
