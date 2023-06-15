<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'QLKH';

// Kết nối tới MYSQL
$dbh = mysqli_connect($servername, $username, $password);

// Nếu kết nối thất bại thì đưa ra thông báo lỗi
if (!$dbh) {
    die("Không thể kết nối đến MYSQL: " . mysqli_error());
}

// Thông báo lỗi nếu chọn CSDL thất bại
if (!mysqli_select_db($dbh, $dbname)) {
    die("Không thể chọn cơ sở dữ liệu: " . mysqli_error($dbh));
}

// Tạo bảng "customers"
$sql_stmt = "CREATE TABLE IF NOT EXISTS customers (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    email VARCHAR(50),
    phone VARCHAR(20)
)";
$result = mysqli_query($dbh, $sql_stmt);

if (!$result) {
    die("Lỗi khi tạo bảng: " . mysqli_error($dbh));
} else {
    echo "Đã tạo bảng customers thành công<br>";
}

// Thêm 5 khách hàng mới vào bảng "customers"
$sql_stmt = "INSERT INTO customers (name, email, phone) VALUES 
    ('NGUYEN GIANG', 'GIANG1102@example.com', '0869674825'),
    ('TRAN GIANG', 'example@gmail.com', '0869674827'),
    ('NGOC LINH', 'NGOCLINH@example.com', '0869674822'),
    ('MINH ANH', 'MINHANH@gmail.com', '0869674821'),
    ('NGOC HA', 'NGOCHA@example.com', '0869674829')";
$result = mysqli_query($dbh, $sql_stmt);

if (!$result) {
    die("Lỗi khi thêm dữ liệu: " . mysqli_error($dbh));
} else {
    echo "Đã thêm 5 khách hàng thành công<br>";
}

// Sửa thông tin của một khách hàng có id là 1
$sql_stmt = "UPDATE customers SET email = 'update@example.com' WHERE id = 1";
$result = mysqli_query($dbh, $sql_stmt);

if (!$result) {
    die("Lỗi khi cập nhật dữ liệu: " . mysqli_error($dbh));
} else {
    echo "Đã cập nhật thông tin khách hàng có id là 1 thành công<br>";
}

// Xoá một khách hàng có id là 5
$sql_stmt = "DELETE FROM customers WHERE id = 5";
$result = mysqli_query($dbh, $sql_stmt);

if (!$result) {
    die("Lỗi khi xoá dữ liệu: " . mysqli_error($dbh));
} else {
    echo "Đã xoá khách hàng có id là 5 thành công<br>";
}

// Lấy tất cả các khách hàng có email là "example@gmail.com"
$getCustomersByEmailQuery = "SELECT * FROM customers WHERE customers.email = 'example@gmail.com'";
$result = mysqli_query($dbh, $getCustomersByEmailQuery);

if (!$result) {
    die("Lỗi khi truy vấn cơ sở dữ liệu: " . mysqli_error($dbh));
}

while ($row = mysqli_fetch_array($result)) { 
    echo "Khách hàng ID: " . $row['id'] . ", Tên: " . $row['name'] . ", Email: " . $row['email'] . ", Số điện thoại: " . $row['phone'] . "<br>";
}

// Tạo bảng "orders"
$createOrdersTableQuery = "CREATE TABLE IF NOT EXISTS orders (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    customer_id INT(11),
    total_amount DECIMAL(10, 2),
    order_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
)";
$result = mysqli_query($dbh, $createOrdersTableQuery);

if (!$result) {
    die("Lỗi: " . mysqli_error($dbh));
} else {
    echo "Đã tạo bảng orders thành công<br>";
}

// Thêm một đơn hàng mới vào bảng "orders" cho khách hàng có id là 3
$insertOrderQuery = "INSERT INTO orders (customer_id, total_amount, order_date) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($dbh, $insertOrderQuery);

$customerId = 3;
$totalAmount = 100.50;
$orderDate = date('Y-m-d');

mysqli_stmt_bind_param($stmt, "ids", $customerId, $totalAmount, $orderDate);
$result = mysqli_stmt_execute($stmt);

if (!$result) {
    die("Lỗi khi thêm đơn hàng: " . mysqli_error($dbh));
} else {
    echo "Thêm đơn hàng thành công<br>";
}

// Lấy tất cả các đơn hàng của khách hàng có id là 3
$getOrdersByCustomerIdQuery = "SELECT * FROM orders WHERE customer_id = ?";
$stmt = mysqli_prepare($dbh, $getOrdersByCustomerIdQuery);
$customerId = 3;
mysqli_stmt_bind_param($stmt, "i", $customerId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Đơn hàng ID: " . $row['id'] . ", Khách hàng ID: " . $row['customer_id'] . ", Tổng số tiền: " . $row['total_amount'] . ", Ngày đặt hàng: " . $row['order_date'] . "<br>";
    }
} else {
    die("Lỗi: " . mysqli_error($dbh));
}

// Lấy danh sách khách hàng và đơn hàng của họ, sử dụng câu lệnh JOIN
$getCustomersAndOrdersQuery = "SELECT customers.id, customers.name, orders.id AS order_id, orders.total_amount, orders.order_date
    FROM customers
    LEFT JOIN orders ON customers.id = orders.customer_id";
$result = mysqli_query($dbh, $getCustomersAndOrdersQuery);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Khách hàng ID: " . $row['id'] . ", Tên: " . $row['name'] . ", Đơn hàng ID: " . $row['order_id'] . ", Tổng số tiền: " . $row['total_amount'] . ", Ngày đặt hàng: " . $row['order_date'] . "<br>";
    }
} else {
    die("Lỗi: " . mysqli_error($dbh));
}

// Lấy danh sách email của khách hàng, sử dụng hàm DISTINCT
$getDistinctEmailsQuery = "SELECT DISTINCT email FROM customers";
$result = mysqli_query($dbh, $getDistinctEmailsQuery);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Email: " . $row['email'] . "<br>";
    }
} else {
    die("Lỗi: " . mysqli_error($dbh));
}

// Đóng kết nối
mysqli_close($dbh);
?>
