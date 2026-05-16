<?php
    session_start();
    include "../connectdb.php";
    include "../function.php";

    if (isset($_POST['quay_lai'])) {
        header("Location: dang_nhap.php");
        exit();
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $vai_tro = $_POST['vai_tro'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>k72_nhom_23</title>
    <link rel="icon" href="../img/nhom_23.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Thêm Font Awesome -->
    <style>
        body {
            background-image: url('../img/background.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            margin: auto;
            display: flex;
            justify-content: center;
            margin-top: 105px;
        }
        .form {
            width: 400px;
            border: 2px solid darkblue;
            padding: 10px 20px;
            border-radius: 20px;
            background-color: white;
            opacity: 0.95; /* Hiệu ứng mờ nền */
            position: relative;
        }
        .form img {
            width: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }
        .logo-container {
            display: flex;
            justify-content: center;
        }
        .input-container {
            position: relative;
            width: 100%;
        }
        .input-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
        }
        .input-container input {
            width: 89%;
            padding: 10px 0px 10px 40px; /* Dành không gian cho icon */
            border: 2px solid darkblue;
            border-radius: 10px;
            margin: 10px 0;
        }
        .radio-container {
            display: flex;
            justify-content: space-around;
            margin: 10px ;
        }
        .radio-container i {
            margin-right: 6px;
        }
        .radio-container label {
            display: flex;
            align-items: center;
        }
        .radio-container input {
            margin-right: 5px;
            transform: scale(1.5);
        }
        #dang_ky {
            width: 100%;
            background-color: darkblue;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            margin: 10px 0;
        }
        #quay_lai.btn {
        display: block;
        text-align: center;
        text-decoration: none;
        width: 96%;
        background-color: white;
        color: midnightblue;
        border: 2px solid darkblue;
        padding: 6px;
        border-radius: 10px;
        margin: 5px 0 8px 0;
        }
        .text_dang_nhap {
            color: darkblue;
            text-align: center;
            margin: 5px;
        }
        .vt {
            margin: 0px;
            margin-left: -15px;
            padding: 7px 0px 7px 10px;
            width: 180px;
            border-radius: 10px;
            border: 2px solid darkblue;
        }
        #p {
            text-align: center;
            color: red;
            background: pink;
            border-radius: 5px;
            height: 20px;
            padding: 5px;
            margin: 10px 0 -10px 0;
        }
        #p2 {
            text-align: center;
            color: green;
            background: lightgreen;
            border-radius: 5px;
            height: 20px;
            padding: 5px;
            margin: 10px 0 -10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form">
            <h2 class="text_dang_nhap">
                <img src="../img/hnue.png" alt="HNUE Logo"> Đăng ký xét tuyển đại học
            </h2>
            <form id="" method="POST">
                <div class="input-container">
                    <label for="username"></label>
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Nhập tài khoản đăng ký" value="<?= htmlspecialchars($username) ?>" required>
                </div>
                <div class="input-container">
                    <label for="password"></label>
                    <i class="fa fa-key"></i>
                    <input type="text" name="password" id="password" placeholder="Nhập mật khẩu đăng ký" value="<?= htmlspecialchars($password) ?>" required>
                </div>
                <div class="radio-container"><p class="vt"><i class="fa fa-users"></i>  Vai trò người dùng: </p> 
                    <label>
                        <input type="radio" name="vai_tro" value="giáo viên" <?= $vai_tro === 'giáo viên' ? 'checked' : '' ?>> Giáo viên
                    </label>
                    <label>
                        <input type="radio" name="vai_tro" value="học sinh" <?= $vai_tro === 'học sinh' ? 'checked' : '' ?>> Học sinh
                    </label>
                </div>
                <div>
                    <button type="submit" id="dang_ky" name="btn_dang_ky" class="">Đăng Ký</button>
                </div>
                <div>
                    <a href="dang_nhap.php" id="quay_lai" class="btn">Quay lại</a>
                </div>
            </form>
            <?php
            if (isset($_POST['btn_dang_ky'])) {
                if (kiem_tra_tai_khoan($username)) {
                    echo "<p id='p'>Tài khoản đã tồn tại!<p/>";
                } else {
                    if (them_nguoi_dung($username, $password, $vai_tro)) {
                        echo "<p id='p2'>Đăng ký tài khoản thành công!<p/>";
                    } else {
                        echo "<p id='p'>Đăng ký tài khoản thất bại!<p/>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
