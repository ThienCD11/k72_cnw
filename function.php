<?php
    include "connectdb.php";

    function sua_nganh($id_nganh) {
        global $conn;
        $sql = "SELECT * FROM nganh_hoc WHERE id_nganh = $id_nganh"; 
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result); 
    }
    function sua_khoi_theo_nganh($id_nganh) {
        global $conn;
        $sql = "SELECT * FROM khoi_xet_tuyen WHERE id_nganh = $id_nganh"; 
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; 
        }
        return $data; 
    }
    function cap_nhat_nganh_va_khoi($data) {
        global $conn;
        $sql1 = "UPDATE nganh_hoc SET ten_nganh = '{$data['ten_nganh']}', ngay_bat_dau = '{$data['ngay_bat_dau']}', ngay_ket_thuc = '{$data['ngay_ket_thuc']}' WHERE id_nganh = {$data['id_nganh']}";
        if (!mysqli_query($conn, $sql1)) return false;

        foreach ($data['khoi_data'] as $khoi) {
            $sql2 = "UPDATE khoi_xet_tuyen SET ten_khoi = '{$khoi['ten_khoi']}', mon1 = '{$khoi['mon1']}', mon2 = '{$khoi['mon2']}', mon3 = '{$khoi['mon3']}' WHERE id_khoi = {$khoi['id_khoi']}";
            if (!mysqli_query($conn, $sql2)) return false;
        }
        return true;
    }    
    function them_nguoi_dung($username, $password, $vai_tro) {
        global $conn;
        $hashed_password = md5($password);
        $sql = "INSERT INTO nguoi_dung (tai_khoan, mat_khau, vai_tro) VALUES ('$username', '$hashed_password', '$vai_tro')";
        return mysqli_query($conn, $sql);
    }
    function danh_sach_nganh() {
        global $conn;
        $ds_nganh = [];
        $sql = "
            SELECT nganh_hoc.id_nganh, nganh_hoc.ten_nganh, khoi_xet_tuyen.ten_khoi, 
            nganh_hoc.ngay_bat_dau, nganh_hoc.ngay_ket_thuc, nganh_hoc.an_hien
            FROM nganh_hoc
            LEFT JOIN khoi_xet_tuyen ON nganh_hoc.id_nganh = khoi_xet_tuyen.id_nganh
            ORDER BY nganh_hoc.id_nganh, khoi_xet_tuyen.ten_khoi;
        ";
        $result = mysqli_query($conn, $sql);
    
        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $id_nganh = $row['id_nganh'];
            // Kiểm tra nếu ngành đã tồn tại, chỉ cần thêm các khối và ngày bắt đầu/kết thúc
            if (!isset($ds_nganh[$id_nganh])) {
                $ds_nganh[$id_nganh] = [
                    'id_nganh' => $id_nganh,
                    'ten_nganh' => $row['ten_nganh'],
                    'ngay_bat_dau' => $row['ngay_bat_dau'],
                    'ngay_ket_thuc' => $row['ngay_ket_thuc'],
                    'an_hien' => $row['an_hien'], 
                    'khoi_xet_tuyen' => []
                ];
            }
            // Thêm khối xét tuyển vào danh sách ngành nếu có
            if (!empty($row['ten_khoi'])) {
                $ds_nganh[$id_nganh]['khoi_xet_tuyen'][] = $row['ten_khoi'];
            }
        }
        return array_values($ds_nganh);
    }
    function lay_ten_nganh($id_nganh) {
        global $conn;
        $sql = "SELECT ten_nganh FROM nganh_hoc WHERE id_nganh = $id_nganh";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['ten_nganh'] ?? "Không xác định";
    }    
    function lay_khoi_xet_tuyen($id_nganh) {
        global $conn;
        $sql = "SELECT id_khoi, ten_khoi, mon1, mon2, mon3 FROM khoi_xet_tuyen WHERE id_nganh = $id_nganh";
        $result = mysqli_query($conn, $sql);
        $khoi_xet_tuyen = [];
    
        while ($row = mysqli_fetch_assoc($result)) {
            $khoi_xet_tuyen[] = $row;
        }
        return $khoi_xet_tuyen;
    }
    function trang_thai_an_hien($conn, $id_nganh, $ten_nganh, $an_hien) {
        global $conn;
        if (empty($id_nganh) || empty($ten_nganh)) {
        }
        $an_hien = in_array($an_hien, ['ẩn', 'hiện']) ? $an_hien : 'hiện';
        $sql = "UPDATE nganh_hoc SET an_hien = '$an_hien' WHERE id_nganh = $id_nganh";
        if (mysqli_query($conn, $sql)) {
            return true;  
        } else {
            echo "Error: " . mysqli_error($conn);
            return false;
        }
    }
    function an_hien_nop_ho_so($role) {
        global $conn;
        if ($role == 'học sinh' || $role == 'giáo viên') {
            $query = "SELECT * FROM nganh_hoc WHERE an_hien = 'hiện'";
        } else {
            $query = "SELECT * FROM nganh_hoc";
        }
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        } else {
            return false; // Trả về false nếu truy vấn thất bại
        }
    }
    function cap_nhat_an_hien($id_nganh, $action) {
        global $conn;
        $sql = "SELECT ten_nganh FROM nganh_hoc WHERE id_nganh = $id_nganh";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $ten_nganh = $row['ten_nganh'];
    
            if ($action == 'hide') {
                trang_thai_an_hien($conn, $id_nganh, $ten_nganh, 'ẩn');
            } elseif ($action == 'show') {
                trang_thai_an_hien($conn, $id_nganh, $ten_nganh, 'hiện');
            }
        } else {
            return false;
        }
        return true;
    }
    function dang_nhap($tk, $mk) {
        global $conn;
        // $mk = md5($mk);
        $sql = "SELECT * FROM `nguoi_dung` WHERE tai_khoan='$tk' and mat_khau='$mk'";
        $kq = mysqli_query($conn,$sql);
        if (mysqli_num_rows($kq)>0) {
            return mysqli_fetch_array($kq);
        } else {
            return 0;
        }
    }
    function kiem_tra_dang_nhap() {
        if(isset($_SESSION['username'])){
            return 1;
        } else {
            return 0;
        }
    }
    function them_ho_so($ho_ten, $nganh, $khoi_xet, $mon1, $diem1, $mon2, $diem2, $mon3, $diem3, $hoc_ba_path) {
        global $conn; // Kết nối CSDL
    
        // Tạo câu lệnh SQL
        $sql = "INSERT INTO thong_tin 
                (ho_ten_hoc_sinh, nganh_nop_ho_so, khoi_xet, mon1, diem1, mon2, diem2, mon3, diem3, hoc_ba, nguoi_duyet, trang_thai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'chưa có', 'chưa duyệt')";
    
        // Chuẩn bị và thực thi
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Chuẩn bị truy vấn thất bại: " . $conn->error);
        }
        $stmt->bind_param("ssssdsdsds", $ho_ten, $nganh, $khoi_xet, $mon1, $diem1, $mon2, $diem2, $mon3, $diem3, $hoc_ba_path);
        return $stmt->execute();
    }    
    function xoa_ho_so($id_hoc_sinh) {
        global $conn;
        $sql = "DELETE FROM thong_tin WHERE id_hoc_sinh = $id_hoc_sinh";
    
        if (mysqli_query($conn, $sql)) {
            return true; 
        } else {
            echo "Lỗi khi xóa hồ sơ: " . mysqli_error($conn);
            return false; 
        }
    }    
    function lay_ho_so($ten_nganh) {
        global $conn;
        $ds_ho_so = [];
        if ($ten_nganh) {
            $sql = "SELECT id_hoc_sinh, ho_ten_hoc_sinh, nganh_nop_ho_so, khoi_xet, nguoi_duyet, trang_thai 
                    FROM thong_tin WHERE nganh_nop_ho_so = '$ten_nganh'";
        } 
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($conn));
        }
    
        while ($row = mysqli_fetch_assoc($result)) {
            $ds_ho_so[] = [
                'id_hoc_sinh' => $row['id_hoc_sinh'],
                'ho_ten_hoc_sinh' => $row['ho_ten_hoc_sinh'],
                'nganh_nop_ho_so' => $row['nganh_nop_ho_so'],
                'khoi_xet' => $row['khoi_xet'],
                'nguoi_duyet' => $row['nguoi_duyet'],
                'trang_thai' => $row['trang_thai']
            ];
        }
        return $ds_ho_so;
    }    
    function ho_so_chi_tiet($ten_nganh) {
        global $conn;
        $ds_ho_so = [];
        if ($ten_nganh) {
        $sql = " SELECT ho_ten_hoc_sinh, nganh_nop_ho_so, khoi_xet, mon1, diem1, mon2, 
                diem2, mon3, diem3, hoc_ba FROM thong_tin WHERE nganh_nop_ho_so = '$ten_nganh'";
        }
        $result = mysqli_query($conn, $sql);   
        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($conn));
        }    

        while ($row = mysqli_fetch_assoc($result)) {
            $ds_ho_so[] = [
                'ho_ten_hoc_sinh' => $row['ho_ten_hoc_sinh'],
                'nganh_nop_ho_so' => $row['nganh_nop_ho_so'],
                'khoi_xet' => $row['khoi_xet'],
                'diem_mon1' => (!empty($row['mon1']) && !empty($row['diem1'])) ? $row['mon1'] . ": " . $row['diem1'] : 'Không có dữ liệu',
                'diem_mon2' => (!empty($row['mon2']) && !empty($row['diem2'])) ? $row['mon2'] . ": " . $row['diem2'] : 'Không có dữ liệu',
                'diem_mon3' => (!empty($row['mon3']) && !empty($row['diem3'])) ? $row['mon3'] . ": " . $row['diem3'] : 'Không có dữ liệu',
                'hoc_ba' => $row['hoc_ba']
            ];
        }
        return $ds_ho_so;    
    }
    function cap_nhat_trang_thai($conn, $id_hoc_sinh, $trang_thai, $nguoi_duyet) {
        global $conn;
        $trang_thai = in_array($trang_thai, ['đã duyệt', 'không duyệt', 'chưa duyệt']) ? $trang_thai : 'chưa duyệt';
        $nguoi_duyet = in_array($nguoi_duyet, ['admin', 'giáo viên', 'chưa có']) ? $nguoi_duyet : 'chưa có';
    
        $sql = "UPDATE thong_tin SET trang_thai = '$trang_thai', nguoi_duyet = '$nguoi_duyet' WHERE id_hoc_sinh = $id_hoc_sinh";
    
        if (mysqli_query($conn, $sql)) {
            return true; 
        } else {
            return false; 
        }
    }
    function thong_ke_ho_so() {
        global $conn;
        $sql = "
            SELECT nganh_nop_ho_so,
                   SUM(CASE WHEN trang_thai = 'chưa duyệt' THEN 1 ELSE 0 END) AS chua_duyet,
                   SUM(CASE WHEN trang_thai = 'đã duyệt' THEN 1 ELSE 0 END) AS da_duyet,
                   SUM(CASE WHEN trang_thai = 'không duyệt' THEN 1 ELSE 0 END) AS khong_duyet
            FROM thong_tin
            GROUP BY nganh_nop_ho_so
        ";
        $result = mysqli_query($conn, $sql);
    
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    function kiem_tra_thoi_gian($ten_nganh) {
        global $conn;
        $sql = "SELECT ngay_bat_dau, ngay_ket_thuc FROM nganh_hoc WHERE ten_nganh = '$ten_nganh'";
        $result = mysqli_query($conn, $sql);
        
        if (!$result || mysqli_num_rows($result) == 0) {
            return false;
        }
        
        $row_time = mysqli_fetch_assoc($result);
        $ngay_bat_dau = $row_time['ngay_bat_dau'];
        $ngay_ket_thuc = $row_time['ngay_ket_thuc'];
        $current_date = date('Y-m-d');
        
        return ($current_date >= $ngay_bat_dau && $current_date <= $ngay_ket_thuc);
    }
    function kiem_tra_nop_ho_so($ho_ten, $ten_nganh) {
        global $conn;
        $sql = "SELECT COUNT(*) AS count FROM thong_tin WHERE ho_ten_hoc_sinh = '$ho_ten' AND nganh_nop_ho_so = '$ten_nganh'";
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($conn));
        }
        
        $row_check = mysqli_fetch_assoc($result);
        return $row_check['count'] > 0; 
    }
    function lay_tai_khoan() {
        global $conn;
        $sql = "SELECT id_nguoi_dung, tai_khoan, mat_khau, vai_tro FROM nguoi_dung";
        $result = mysqli_query($conn, $sql);
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    function xoa_nguoi_dung($id_nguoi_dung) {
        global $conn;
        $sql = "DELETE FROM nguoi_dung WHERE id_nguoi_dung = $id_nguoi_dung";
        return mysqli_query($conn, $sql);
    }
    function kiem_tra_tai_khoan($username) {
        global $conn;
        $sql = "SELECT COUNT(*) AS count FROM nguoi_dung WHERE tai_khoan = '$username'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'] > 0; 
        }
        return false; 
    }    
    function anh() {
        global $conn;
        $sql = "SELECT hoc_ba FROM thong_tin";
        $result = mysqli_query($conn, $sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
?>

