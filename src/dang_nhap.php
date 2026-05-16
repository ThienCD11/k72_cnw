<?php
    session_start();
    include "../connectdb.php";
    include "../function.php";

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
        #dang_nhap {
            width: 100%;
            background-color: darkblue;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            margin: 10px 0;
        }
        #dang_ky.btn {
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
        #p {
            text-align: center;
            color: red;
            background: pink;
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
                    <input type="text" name="username" id="username" placeholder="Nhập tài khoản" required>
                </div>
                <div class="input-container">
                    <label for="password"></label>
                    <i class="fa fa-key"></i>
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div>
                    <button type="submit" id="dang_nhap" name="btn_dang_nhap" class="">Đăng Nhập</button>
                </div>
                <div>
                    <a href="dang_ky.php" id="dang_ky" class="btn">Đăng Ký</a>
                </div>
            </form>
            <?php
            if (isset($_POST['btn_dang_nhap'])){
                $tk = $_POST['username'];
                $mk = $_POST['password'];
                $mk = md5($mk);
                if (dang_nhap($tk,$mk)!=0) {
                    $a = dang_nhap($tk, $mk);
                    $_SESSION['username'] = $a['tai_khoan'];
                    $_SESSION['password'] = $a['mat_khau'];
                    $_SESSION['vai_tro'] = $a['vai_tro'];
                    header("location: trang_chu.php");
                } else {
                    echo "<p id='p'>Tài khoản hoặc mật khẩu không đúng!<p/>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
