<?php
const DB_TYPE = "mysql";
const DB_HOST = "localhost";
const DB_NAME = "QLBH";
const USER_NAME = "root";
const USER_PASSWORD = "";

try {
    // Kết nối tới MySQL 
        $conn = new PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME, USER_NAME, USER_PASSWORD);

    // Thiết lập chế độ exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tạo bảng khách hàng
    $sql_stmt = "CREATE TABLE IF NOT EXISTS KH (
        MAKH CHAR(4) PRIMARY KEY,
        HOTEN VARCHAR(40),
        DCHI VARCHAR(50),
        SODT VARCHAR(20),
        NGSINH DATE,
        NGDK DATE,
        DOANHSO DECIMAL(10, 2)
    )";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute();
    echo "Đã tạo bảng khách hàng thành công<br>";

    // Tạo bảng nhân viên
    $sql_stmt = "CREATE TABLE IF NOT EXISTS NV (
        MANV CHAR(4) PRIMARY KEY,
        HOTEN VARCHAR(40),
        SODT VARCHAR(20),
        NGVL DATE
    )";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute();
    echo "Đã tạo bảng nhân viên thành công<br>";

    // Tạo bảng sản phẩm
    $sql_stmt = "CREATE TABLE IF NOT EXISTS SP (
        MASP CHAR(4) PRIMARY KEY,
        TENSP VARCHAR(40),
        DVT VARCHAR(20),
        NUOCSX VARCHAR(40),
        GIA DECIMAL(10, 2)
    )";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute();
    echo "Đã tạo bảng sản phẩm thành công<br>";

    // Tạo bảng hóa đơn
    $sql_stmt = "CREATE TABLE IF NOT EXISTS HD (
        SOHD INT PRIMARY KEY AUTO_INCREMENT,
        NGHD DATE,
        MAKH CHAR(4),
        MANV CHAR(4),
        FOREIGN KEY (MAKH) REFERENCES KH(MAKH) ON DELETE CASCADE,
        FOREIGN KEY (MANV) REFERENCES NV(MANV) ON DELETE CASCADE,
        TRIGIA DECIMAL(10, 2)
    )";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute();
    echo "Đã tạo bảng hóa đơn thành công<br>";

    // Tạo bảng chi tiết hóa đơn
    $sql_stmt = "CREATE TABLE IF NOT EXISTS CTHD (
        SOHD INT,
        MASP CHAR(4),
        FOREIGN KEY (SOHD) REFERENCES HD(SOHD) ON DELETE CASCADE,
        FOREIGN KEY (MASP) REFERENCES SP(MASP) ON DELETE CASCADE,
        SL INT
    )";
    $stmt = $conn->prepare($sql_stmt);
    $stmt->execute();
    echo "Đã tạo bảng chi tiết hóa đơn thành công<br>";

    //Thêm 5 nhân viên
    $stmt = $conn->prepare("INSERT INTO NV (MANV, HOTEN, SODT, NGVL) VALUES (?, ?, ?, ?)");
    $nv = array(
        array('NV01', 'Nguyen Nhu Nhut', '0927345678', '13/4/2006'),
        array('NV02', 'Le Thi Phi Yen', '0987567390', '21/4/2006'),
        array('NV03', 'Nguyen Van B', '0997047382', '27/4/2006'),
        array('NV04', 'Ngo Thanh Tuan', '0913758498', '24/6/2006'),
        array('NV05', 'Nguyen Thi Truc Thanh', '0918590387', '20/7/2006')
        );
    foreach ($nv as $nv) {
        $stmt->execute($nv);
    }
    echo "<br>Đã thêm 5 nhân viên thành công<br>";

    //Thêm 10 khách hàng
    $stmt = $conn->prepare("INSERT INTO KH (MAKH, HOTEN, DCHI, SODT, NGSINH, DOANHSO, NGDK) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $kh = array(
        array('KH01', 'Nguyen Van A', '731 Tran Hung Dao, Q5, TpHCM', '08823451', '22/10/1960', 13060000, '22/07/2006'),
        array('KH02', 'Tran Ngoc Han', '23/5 Nguyen Trai, Q5, TpHCM', '0908256478', '3/4/1974', 280000, '30/07/2006'),
        array('KH03', 'Tran Ngoc Linh', '45 Nguyen Canh Chan, Q1, TpHCM', '0938776266', '12/06/1980', 3860000, '05/08/2006'),
        array('KH04', 'Tran Minh Long', '50/34 Le Dai Hanh, Q10, TpHCM', '0917325476', '9/3/1965', 250000, '02/10/2006'),
        array('KH05', 'Le Nhat Minh', '34 Truong Dinh, Q3, TpHCM', '08246108', '10/3/1950', 21000, '28/10/2006'),
        array('KH06', 'Le Hoai Thuong', '227 Nguyen Van Cu, Q5, TpHCM', '08631738', '31/12/1981', 915000, '24/11/2006'),
        array('KH07', 'Nguyen Van Tam', '32/3 Tran Binh Trong, Q5, TpHCM', '0916783565', '6/4/1971', 12500, '01/12/2006'),
        array('KH08', 'Phan Thi Thanh', '45/2 An Duong Vuong, Q5, TpHCM', '0938435756', '10/1/1971', 365000, '13/12/2006'),
        array('KH09', 'Le Ha Vinh', '873 Le Hong Phong, Q5, TpHCM', '08654763', '3/9/1979', 70000, '14/01/2007'),
        array('KH10', 'Ha Duy Lap', '34/34B Nguyen Trai, Q1, TpHCM', '08768904', '2/5/1983', 67500, '16/01/2007')
        );
    foreach ($kh as $kh) {
        $stmt->execute($kh);
    }
    echo "<br>Đã thêm 10 khách hàng thành công<br>";

    //Thêm sản phẩm 
    $stmt = $conn->prepare("INSERT INTO SP (MASP, TENSP, DVT, NUOCSX, GIA) VALUES (?, ?, ?, ?, ?)");
    $sp = array(
        array('BC01', 'But chi', 'cay', 'Singapore', '3000'),
        array('BC02', 'But chi', 'cay', 'Singapore', '5000'),
        array('BC03', 'But chi', 'cay', 'Viet Nam', '3500'),
        array('BC04', 'But chi', 'hop', 'Viet Nam', '30000'),
        array('BB01', 'But bi', 'cay', 'Viet Nam', '5000'),
        array('BB02', 'But bi', 'cay', 'Trung Quoc', '7000'),
        array('BB03', 'But bi', 'hop', 'Thai Lan', '100000'),
        array('TV01', 'Tap 100 giay mong', 'quyen', 'Trung Quoc', '2500'),
        array('TV02', 'Tap 200 giay mong', 'quyen', 'Trung Quoc', '4500'),
        array('TV03', 'Tap 100 giay tot', 'quyen', 'Viet Nam', '3000'),
        array('TV04', 'Tap 200 giay tot', 'quyen', 'Viet Nam', '5500'),
        array('TV05', 'Tap 100 trang', 'chuc', 'Viet Nam', '23000'),
        array('TV06', 'Tap 200 trang', 'chuc', 'Viet Nam', '53000'),
        array('TV07', 'Tap 100 trang', 'chuc', 'Trung Quoc', '34000'),
        array('ST01', 'So tay 500 trang', 'quyen', 'Trung Quoc', '40000'),
        array('ST02', 'So tay loai 1', 'quyen', 'Viet Nam', '55000'),
        array('ST03', 'So tay loai 2', 'quyen', 'Viet Nam', '51000'),
        array('ST04', 'So tay', 'quyen', 'Thai Lan', '55000'),
        array('ST05', 'So tay mong', 'quyen', 'Thai Lan', '20000'),
        array('ST06', 'Phan viet bang', 'hop', 'Viet Nam', '5000'),
        array('ST07', 'Phan khong bui', 'hop', 'Viet Nam', '7000'),
        array('ST08', 'Bong bang', 'cai', 'Viet Nam', '1000'),
        array('ST09', 'But long', 'cay', 'Viet Nam', '5000'),
        array('ST10', 'But long', 'cay', 'Trung Quoc', '7000')
        );
    foreach ($sp as $sp) {
        $stmt->execute($sp);
    }
    echo "<br>Đã thêm sản phẩm thành công<br>";

    //Thêm hóa đơn
    $stmt = $conn->prepare("INSERT INTO HD(SOHD, NGHD, MAKH, MANV, TRIGIA) VALUES (?, ?, ?, ?, ?)");
    $hd = array(
        array('1001', '23/07/2006', 'KH01','NV01',320000),
        array('1002', '12/08/2006', 'KH01','NV02',840000),
        array('1003', '23/08/2006', 'KH02','NV01',100000),
        array('1004', '01/09/2006', 'KH02','NV01',180000),
        array('1005', '20/10/2006', 'KH01','NV02',3800000),
        array('1006', '16/10/2006', 'KH01','NV03',2430000),
        array('1007', '28/10/2006', 'KH03','NV03',510000),
        array('1008', '28/10/2006', 'KH01','NV03',440000),
        array('1009', '28/10/2006', 'KH03','NV04',200000),
        array('1010', '01/11/2006', 'KH01','NV01',5200000),
        array('1011', '04/11/2006', 'KH04','NV03',250000),
        array('1012', '30/11/2006', 'KH05','NV03',21000),
        array('1013', '12/12/2006', 'KH06','NV01',5000),
        array('1014', '31/12/2006', 'KH03','NV02',3150000),
        array('1015', '01/01/2007', 'KH06','NV01',910000),
        array('1016', '01/01/2007', 'KH07','NV02',12500),
        array('1017', '02/01/2007', 'KH08','NV03',35000),
        array('1018', '13/01/2007', 'KH08','NV03',330000),
        array('1019', '13/01/2007', 'KH01','NV03',30000),
        array('1020', '14/01/2007', 'KH09','NV04',70000),
        array('1021', '16/01/2007', 'KH10','NV03',67500),
        array('1022', '16/01/2007', Null,'NV03',7000),
        array('1023', '17/01/2007', Null,'NV01',330000)
        );
    foreach ($hd as $hd) {
        $stmt->execute($hd);
    }
    echo "<br>Đã thêm hóa đơn thành công<br>";

    //Thêm chi tiết hóa đơn
    $stmt = $conn->prepare("INSERT INTO CTHD (SOHD, MASP, SL) VALUES (?, ?, ?)");
    $cthd = array(
        array('1001', 'TV02', 10),
        array('1001', 'ST01', 5),
        array('1001', 'BC01', 5),
        array('1001', 'BC02', 10),
        array('1001', 'ST08', 10),
        array('1002', 'BC04', 20),
        array('1002', 'BB01', 20),
        array('1002', 'BB02', 20),
        array('1003', 'BB03', 10),
        array('1004', 'TV01', 20),
        array('1004', 'TV02', 10),
        array('1004', 'TV03', 10),
        array('1004', 'TV04', 10),
        array('1005', 'TV05', 50),
        array('1005', 'TV06', 50),
        array('1006', 'TV07', 20),

        array('1006', 'ST01', 30),
        array('1006', 'ST02', 10),
        array('1007', 'ST03', 10),
        array('1008', 'ST04', 8),
        array('1009', 'ST05', 10),
        array('1010', 'TV07', 50),
        array('1010', 'ST07', 50),
        array('1010', 'ST08', 100),
        array('1010', 'ST04', 50),
        array('1010', 'TV03', 100),
        array('1011', 'ST06', 50),
        array('1012', 'ST07', 3),
        array('1013', 'ST08', 5),
        array('1014', 'BC02', 80),
        array('1014', 'BB02', 100),
        array('1014', 'BC04', 60),

        array('1014', 'BB01', 50),
        array('1015', 'BB02', 30),
        array('1015', 'BB03', 7),
        array('1016', 'TV01', 5),
        array('1017', 'TV02', 1),
        array('1017', 'TV03', 1),
        array('1017', 'TV04', 5),
        array('1018', 'ST04', 6),
        array('1019', 'ST05', 1),
        array('1019', 'ST06', 2),
        array('1020', 'ST07', 10),
        array('1021', 'ST08', 5),
        array('1021', 'TV01', 7),
        array('1021', 'TV02', 10),
        array('1022', 'ST07', 1),
        array('1023', 'ST04', 6)
        );
    foreach ($cthd as $cthd) {
        $stmt->execute($cthd);
    }
    echo "<br>Đã thêm chi tiết hóa đơn thành công<br>";

    // Thêm vào thuộc tính GHICHU có kiểu dữ liệu varchar(20) cho quan hệ SANPHAM
$sql_stmt = "ALTER TABLE SP ADD GHICHU VARCHAR(20)";
try {
    $conn->exec($sql_stmt);
    echo "Đã thêm thuộc tính GHICHU cho quan hệ SANPHAM thành công<br>";
} catch (PDOException $e) {
    die("Lỗi khi thêm thuộc tính GHICHU cho quan hệ SANPHAM: " . $e->getMessage());
}

// Thêm vào thuộc tính LOAIKH có kiểu dữ liệu là tinyint cho quan hệ KHACHHANG
$sql_stmt = "ALTER TABLE KH ADD LOAIKH TINYINT";
try {
    $conn->exec($sql_stmt);
    echo "Đã thêm thuộc tính LOAIKH cho quan hệ KHACHHANG thành công<br>";
} catch (PDOException $e) {
    die("Lỗi khi thêm thuộc tính LOAIKH cho quan hệ KHACHHANG: " . $e->getMessage());
}

// Cập nhật tên “Nguyễn Văn B” cho dữ liệu Khách Hàng có mã là KH01
$sql_stmt = "UPDATE KH SET HOTEN = 'Nguyễn Văn B' WHERE MAKH = 'KH01'";
try {
    $conn->exec($sql_stmt);
    echo "Đã cập nhật tên cho Khách Hàng có mã KH01 thành công<br>";
} catch (PDOException $e) {
    die("Lỗi khi cập nhật tên cho Khách Hàng có mã KH01: " . $e->getMessage());
}

// Cập nhật tên “Nguyễn Văn Hoan” cho dữ liệu Khách Hàng có mã là KH09 và năm đăng ký là 2007
$sql_stmt = "UPDATE KH SET HOTEN = 'Nguyễn Văn Hoan' WHERE MAKH = 'KH09' AND YEAR(NGDK) = 2007";
try {
    $conn->exec($sql_stmt);
    echo "Đã cập nhật tên cho Khách Hàng có mã KH09 và năm đăng ký là 2007 thành công<br>";
} catch (PDOException $e) {
    die("Lỗi khi cập nhật tên cho Khách Hàng có mã KH09 và năm đăng ký là 2007: " . $e->getMessage());
}

// Sửa kiểu dữ liệu của thuộc tính GHICHU thành varchar(100)
$sql_stmt = "ALTER TABLE SP MODIFY COLUMN GHICHU VARCHAR(100)";
try {
    $conn->exec($sql_stmt);
    echo "Đã sửa kiểu dữ liệu của thuộc tính GHICHU thành varchar(100)<br>";
} catch (PDOException $e) {
    die("Lỗi khi sửa kiểu dữ liệu của thuộc tính GHICHU: " . $e->getMessage());
}



 // Đóng kết nối
 $conn = null;
} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
?>