<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'QLBH';

// Kết nối tới MySQL
$conn = mysqli_connect($servername, $username, $password);

// Kiểm tra kết nối
if (!$conn) {
    die("Không thể kết nối đến MySQL: " . mysqli_connect_error());
}

// Thông báo lỗi nếu chọn CSDL thất bại
if (!mysqli_select_db($conn, $dbname)) 
    die("Không thể chọn cơ sở dữ liệu: " . mysqli_error($conn));


/// Tạo bảng khách hàng
$sql_stmt = "CREATE TABLE IF NOT EXISTS KH (
    MAKH CHAR(4) PRIMARY KEY,
    HOTEN VARCHAR(40),
    DCHI VARCHAR(50),
    SODT VARCHAR(20),
    NGSINH DATE,
    NGDK DATE,
    DOANHSO DECIMAL(10, 2)
)";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi tạo bảng khách hàng: " . mysqli_error($conn));
} else {
    echo "Đã tạo bảng khách hàng thành công<br>";
}

// Tạo bảng nhân viên
$sql_stmt = "CREATE TABLE IF NOT EXISTS NV (
    MANV CHAR(4) PRIMARY KEY,
    HOTEN VARCHAR(40),
    SODT VARCHAR(20),
    NGVL DATE
)";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi tạo bảng nhân viên: " . mysqli_error($conn));
} else {
    echo "Đã tạo bảng nhân viên thành công<br>";
}

// Tạo bảng sản phẩm
$sql_stmt = "CREATE TABLE IF NOT EXISTS SP (
    MASP CHAR(4) PRIMARY KEY,
    TENSP VARCHAR(40),
    DVT VARCHAR(20),
    NUOCSX VARCHAR(40),
    GIA DECIMAL(10, 2)
)";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi tạo bảng sản phẩm: " . mysqli_error($conn));
} else {
    echo "Đã tạo bảng sản phẩm thành công<br>";
}

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
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi tạo bảng hóa đơn: " . mysqli_error($conn));
} else {
    echo "Đã tạo bảng hóa đơn thành công<br>";
}

// Tạo bảng chi tiết hóa đơn
$sql_stmt = "CREATE TABLE IF NOT EXISTS CTHD (
    SOHD INT,
    MASP CHAR(4),
    FOREIGN KEY (SOHD) REFERENCES HD(SOHD) ON DELETE CASCADE,
    FOREIGN KEY (MASP) REFERENCES SP(MASP) ON DELETE CASCADE,
    SL INT
)";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi tạo bảng chi tiết hóa đơn: " . mysqli_error($conn));
} else {
    echo "Đã tạo bảng chi tiết hóa đơn thành công<br>";
}

//Thêm 5 nhân viên
$sql_stmt = "INSERT INTO NV (MANV, HOTEN, SODT, NGVL) 
    VALUES
    ('NV01', 'Nguyen Nhu Nhut', '0927345678', '13/4/2006'),
    ('NV02', 'Le Thi Phi Yen', '0987567390', '21/4/2006'),
    ('NV03', 'Nguyen Van B', '0997047382', '27/4/2006'),
    ('NV04', 'Ngo Thanh Tuan', '0913758498', '24/6/2006'),
    ('NV05', 'Nguyen Thi Truc Thanh', '0918590387', '20/7/2006')";

$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi thêm nhân viên: " . mysqli_error($conn));
} else {
    echo "<br>Đã thêm 5 nhân viên thành công<br>";
}

//Thêm 10 khách hàng
$sql_stmt = "INSERT INTO KH (MAKH, HOTEN, DCHI, SODT, NGSINH, DOANHSO, NGDK)
VALUES
    ('KH01', 'Nguyen Van A', '731 Tran Hung Dao, Q5, TpHCM', '08823451', '22/10/1960', 13060000, '22/07/2006'),
    ('KH02', 'Tran Ngoc Han', '23/5 Nguyen Trai, Q5, TpHCM', '0908256478', '3/4/1974', 280000, '30/07/2006'),
    ('KH03', 'Tran Ngoc Linh', '45 Nguyen Canh Chan, Q1, TpHCM', '0938776266', '12/06/1980', 3860000, '05/08/2006'),
    ('KH04', 'Tran Minh Long', '50/34 Le Dai Hanh, Q10, TpHCM', '0917325476', '9/3/1965', 250000, '02/10/2006'),
    ('KH05', 'Le Nhat Minh', '34 Truong Dinh, Q3, TpHCM', '08246108', '10/3/1950', 21000, '28/10/2006'),
    ('KH06', 'Le Hoai Thuong', '227 Nguyen Van Cu, Q5, TpHCM', '08631738', '31/12/1981', 915000, '24/11/2006'),
    ('KH07', 'Nguyen Van Tam', '32/3 Tran Binh Trong, Q5, TpHCM', '0916783565', '6/4/1971', 12500, '01/12/2006'),
    ('KH08', 'Phan Thi Thanh', '45/2 An Duong Vuong, Q5, TpHCM', '0938435756', '10/1/1971', 365000, '13/12/2006'),
    ('KH09', 'Le Ha Vinh', '873 Le Hong Phong, Q5, TpHCM', '08654763', '3/9/1979', 70000, '14/01/2007'),
    ('KH10', 'Ha Duy Lap', '34/34B Nguyen Trai, Q1, TpHCM', '08768904', '2/5/1983', 67500, '16/01/2007')";
$result = mysqli_query($conn, $sql_stmt);

if(!$result){
    die("Lỗi khi thêm khách hàng: ". mysqli_error($conn));
} else {
    echo "<br>Đã thêm 10 khách hàng thành công <br>";
}

//Thêm sản phẩm 
$sql_stmt = "INSERT INTO SP (MASP, TENSP, DVT, NUOCSX, GIA)
VALUES
    ('BC01', 'But chi', 'cay', 'Singapore', '3000'),
    ('BC02', 'But chi', 'cay', 'Singapore', '5000'),
    ('BC03', 'But chi', 'cay', 'Viet Nam', '3500'),
    ('BC04', 'But chi', 'hop', 'Viet Nam', '30000'),
    ('BB01', 'But bi', 'cay', 'Viet Nam', '5000'),
    ('BB02', 'But bi', 'cay', 'Trung Quoc', '7000'),
    ('BB03', 'But bi', 'hop', 'Thai Lan', '100000'),
    ('TV01', 'Tap 100 giay mong', 'quyen', 'Trung Quoc', '2500'),
    ('TV02', 'Tap 200 giay mong', 'quyen', 'Trung Quoc', '4500'),
    ('TV03', 'Tap 100 giay tot', 'quyen', 'Viet Nam', '3000'),
    ('TV04', 'Tap 200 giay tot', 'quyen', 'Viet Nam', '5500'),
    ('TV05', 'Tap 100 trang', 'chuc', 'Viet Nam', '23000'),
    ('TV06', 'Tap 200 trang', 'chuc', 'Viet Nam', '53000'),
    ('TV07', 'Tap 100 trang', 'chuc', 'Trung Quoc', '34000'),
    ('ST01', 'So tay 500 trang', 'quyen', 'Trung Quoc', '40000'),
    ('ST02', 'So tay loai 1', 'quyen', 'Viet Nam', '55000'),
    ('ST03', 'So tay loai 2', 'quyen', 'Viet Nam', '51000'),
    ('ST04', 'So tay', 'quyen', 'Thai Lan', '55000'),
    ('ST05', 'So tay mong', 'quyen', 'Thai Lan', '20000'),
    ('ST06', 'Phan viet bang', 'hop', 'Viet Nam', '5000'),
    ('ST07', 'Phan khong bui', 'hop', 'Viet Nam', '7000'),
    ('ST08', 'Bong bang', 'cai', 'Viet Nam', '1000'),
    ('ST09', 'But long', 'cay', 'Viet Nam', '5000'),
    ('ST10', 'But long', 'cay', 'Trung Quoc', '7000')";

$result = mysqli_query ($conn, $sql_stmt);

if(!$result){
    die("Lỗi khi thêm sản phẩm:". mysqli_error($conn));
} else {
    echo "<br>Đã thêm sản phẩm thành công<br>";
}

//Thêm hóa đơn
$sql_stmt = "INSERT INTO HD(SOHD, NGHD, MAKH, MANV, TRIGIA)
VALUES
    ('1001', '23/07/2006', 'KH01','NV01',320000),
    ('1002', '12/08/2006', 'KH01','NV02',840000),
    ('1003', '23/08/2006', 'KH02','NV01',100000),
    ('1004', '01/09/2006', 'KH02','NV01',180000),
    ('1005', '20/10/2006', 'KH01','NV02',3800000),
    ('1006', '16/10/2006', 'KH01','NV03',2430000),
    ('1007', '28/10/2006', 'KH03','NV03',510000),
    ('1008', '28/10/2006', 'KH01','NV03',440000),
    ('1009', '28/10/2006', 'KH03','NV04',200000),
    ('1010', '01/11/2006', 'KH01','NV01',5200000),
    ('1011', '04/11/2006', 'KH04','NV03',250000),
    ('1012', '30/11/2006', 'KH05','NV03',21000),
    ('1013', '12/12/2006', 'KH06','NV01',5000),
    ('1014', '31/12/2006', 'KH03','NV02',3150000),
    ('1015', '01/01/2007', 'KH06','NV01',910000),
    ('1016', '01/01/2007', 'KH07','NV02',12500),
    ('1017', '02/01/2007', 'KH08','NV03',35000),
    ('1018', '13/01/2007', 'KH08','NV03',330000),
    ('1019', '13/01/2007', 'KH01','NV03',30000),
    ('1020', '14/01/2007', 'KH09','NV04',70000),
    ('1021', '16/01/2007', 'KH10','NV03',67500),
    ('1022', '16/01/2007', Null,'NV03',7000),
    ('1023', '17/01/2007', Null,'NV01',330000)";
$result = mysqli_query($conn, $sql_stmt);

if(!$result){
    die("Lỗi khi thêm hóa đơn". mysqli_error($conn));
} else {
    echo "<br>Đã thêm hóa đơn thành công <br>";
}


//Thêm chi tiết hóa đơn 
$sql_stmt = "INSERT INTO CTHD (SOHD, MASP, SL)
VALUES
    ('1001', 'TV02', 10),
    ('1001', 'ST01', 5),
    ('1001', 'BC01', 5),
    ('1001', 'BC02', 10),
    ('1001', 'ST08', 10),
    ('1002', 'BC04', 20),
    ('1002', 'BB01', 20),
    ('1002', 'BB02', 20),
    ('1003', 'BB03', 10),
    ('1004', 'TV01', 20),
    ('1004', 'TV02', 10),
    ('1004', 'TV03', 10),
    ('1004', 'TV04', 10),
    ('1005', 'TV05', 50),
    ('1005', 'TV06', 50),
    ('1006', 'TV07', 20),

    ('1006', 'ST01', 30),
    ('1006', 'ST02', 10),
    ('1007', 'ST03', 10),
    ('1008', 'ST04', 8),
    ('1009', 'ST05', 10),
    ('1010', 'TV07', 50),
    ('1010', 'ST07', 50),
    ('1010', 'ST08', 100),
    ('1010', 'ST04', 50),
    ('1010', 'TV03', 100),
    ('1011', 'ST06', 50),
    ('1012', 'ST07', 3),
    ('1013', 'ST08', 5),
    ('1014', 'BC02', 80),
    ('1014', 'BB02', 100),
    ('1014', 'BC04', 60),

    ('1014', 'BB01', 50),
    ('1015', 'BB02', 30),
    ('1015', 'BB03', 7),
    ('1016', 'TV01', 5),
    ('1017', 'TV02', 1),
    ('1017', 'TV03', 1),
    ('1017', 'TV04', 5),
    ('1018', 'ST04', 6),
    ('1019', 'ST05', 1),
    ('1019', 'ST06', 2),
    ('1020', 'ST07', 10),
    ('1021', 'ST08', 5),
    ('1021', 'TV01', 7),
    ('1021', 'TV02', 10),
    ('1022', 'ST07', 1),
    ('1023', 'ST04', 6)";
$result = mysqli_query ($conn, $sql_stmt);

if(!$result) {
    die("Lỗi khi thêm chi tiết hóa đơn". mysqli_error($conn));
} else {
    echo "<br> Đã thêm chi tiết hóa đơn thành công<br>";
}

//Thêm vào thuộc tính GHICHU có kiểu dữ liệu varchar(20) cho quan hệ SANPHAM.
$sql_stmt = "ALTER TABLE SP ADD GHICHU VARCHAR(20)";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi thêm thuộc tính GHICHU cho quan hệ SANPHAM: " . mysqli_error($conn));
} else {
    echo "Đã thêm thuộc tính GHICHU cho quan hệ SANPHAM thành công<br>";
}

//Thêm vào thuộc tính LOAIKH có kiểu dữ liệu là tinyint cho quan hệ KHACHHANG.
$sql_stmt = "ALTER TABLE KH ADD LOAIKH TINYINT";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi thêm thuộc tính LOAIKH cho quan hệ KHACHHANG: " . mysqli_error($conn));
} else {
    echo "Đã thêm thuộc tính LOAIKH cho quan hệ KHACHHANG thành công<br>";
}

//Cập nhật tên “Nguyễn Văn B” cho dữ liệu Khách Hàng có mã là KH01:
$sql_stmt = "UPDATE KH SET HOTEN = 'Nguyễn Văn B' WHERE MAKH = 'KH01'";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi cập nhật tên cho Khách Hàng có mã KH01: " . mysqli_error($conn));
} else {
    echo "Đã cập nhật tên cho Khách Hàng có mã KH01 thành công<br>";
}

//Cập nhật tên “Nguyễn Văn Hoan” cho dữ liệu Khách Hàng có mã là KH09 và năm đăng ký là 2007:
$sql_stmt = "UPDATE KH SET HOTEN = 'Nguyễn Văn Hoan' WHERE MAKH = 'KH09' AND YEAR(NGDK) = 2007";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi cập nhật tên cho Khách Hàng có mã KH09 và năm đăng ký là 2007: " . mysqli_error($conn));
} else {
    echo "Đã cập nhật tên cho Khách Hàng có mã KH09 và năm đăng ký là 2007 thành công<br>";
}

// Sửa kiểu dữ liệu của thuộc tính GHICHU thành varchar(100)
$sql_stmt = "ALTER TABLE SP MODIFY COLUMN GHICHU VARCHAR(100)";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi sửa kiểu dữ liệu của thuộc tính GHICHU: " . mysqli_error($conn));
} else {
    echo "Đã sửa kiểu dữ liệu của thuộc tính GHICHU thành varchar(100)<br>";
}

// Xóa thuộc tính GHICHU trong quan hệ SANPHAM
$sql_stmt = "ALTER TABLE SP DROP COLUMN GHICHU";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi xóa thuộc tính GHICHU: " . mysqli_error($conn));
} else {
    echo "Đã xóa thuộc tính GHICHU trong quan hệ SANPHAM<br>";
}

//Xoá tất cả dữ liệu khách hàng có năm sinh 1971
$sql_stmt = "DELETE FROM KH WHERE YEAR(NGSINH) = 1971";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi xóa dữ liệu khách hàng có năm sinh 1971: " . mysqli_error($conn));
} else {
    echo "Đã xóa tất cả dữ liệu khách hàng có năm sinh 1971<br>";
}

//Xoá tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006
$sql_stmt = "DELETE FROM KH WHERE YEAR(NGSINH) = 1971 AND YEAR(NGDK) = 2006";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi xóa dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006: " . mysqli_error($conn));
} else {
    echo "Đã xóa tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006<br>";
}

//Xoá tất hoá đơn có mã KH = KH01
$sql_stmt = "DELETE FROM HD WHERE MAKH = 'KH01'";
$result = mysqli_query($conn, $sql_stmt);

if (!$result) {
    die("Lỗi khi xóa hóa đơn có mã KH = 'KH01': " . mysqli_error($conn));
} else {
    echo "Đã xóa hóa đơn có mã KH = 'KH01'<br>";
}

// Xóa thuộc tính GHICHU trong quan hệ SANPHAM
$sql_stmt = "ALTER TABLE SP DROP COLUMN GHICHU";
try {
    $conn->exec($sql_stmt);
    echo "Đã xóa thuộc tính GHICHU trong quan hệ SANPHAM<br>";
} catch (PDOException $e) {
    die("Lỗi khi xóa thuộc tính GHICHU: " . $e->getMessage());
}

// Xóa tất cả dữ liệu khách hàng có năm sinh 1971
$sql_stmt = "DELETE FROM KH WHERE YEAR(NGSINH) = 1971";
try {
    $conn->exec($sql_stmt);
    echo "Đã xóa tất cả dữ liệu khách hàng có năm sinh 1971<br>";
} catch (PDOException $e) {
    die("Lỗi khi xóa dữ liệu khách hàng có năm sinh 1971: " . $e->getMessage());
}

// Xóa tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006
$sql_stmt = "DELETE FROM KH WHERE YEAR(NGSINH) = 1971 AND YEAR(NGDK) = 2006";
try {
    $conn->exec($sql_stmt);
    echo "Đã xóa tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006<br>";
} catch (PDOException $e) {
    die("Lỗi khi xóa dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006: " . $e->getMessage());
}

// Xóa hóa đơn có mã KH = 'KH01'
$sql_stmt = "DELETE FROM HD WHERE MAKH = 'KH01'";
try {
    $conn->exec($sql_stmt);
    echo "Đã xóa hóa đơn có mã KH = 'KH01'<br>";
} catch (PDOException $e) {
    die("Lỗi khi xóa hóa đơn có mã KH = 'KH01': " . $e->getMessage());
}

// Đóng kết nối
mysqli_close($conn);
?>