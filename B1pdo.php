<?php
const DB_TYPE = "mysql";
const DB_HOST = "localhost";
const DB_NAME = "QLKH";
const USER_NAME = "root";
const USER_PASSWORD = "";

try {
    // Kết nối tới MySQL 
    $dbh = new PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME, USER_NAME, USER_PASSWORD);
    // Thiết lập chế độ exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tạo bảng "customers"
    $sql_stmt = "CREATE TABLE IF NOT EXISTS customers (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        email VARCHAR(50),
        phone VARCHAR(20)
    )";
    $dbh->exec($sql_stmt);
    echo "<br>Đã tạo bảng customers thành công<br>";

    // Thêm 5 khách hàng mới vào bảng "customers"
    $stmt = $dbh->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
    $customers = array(
        array('NGUYEN GIANG', 'GIANG1102@example.com', '0869674825'),
        array('TRAN GIANG', 'example@gmail.com', '0869674827'),
        array('NGOC LINH', 'NGOCLINH@example.com', '0869674822'),
        array('MINH ANH', 'MINHANH@gmail.com', '0869674821'),
        array('NGOC HA', 'NGOCHA@example.com', '0869674829')
        );
    foreach ($customers as $customer) {
        $stmt->execute($customer);
    }
    echo "<br>Đã thêm 5 khách hàng thành công<br>";

    // Sửa thông tin của một khách hàng có id là 1
    $customerId = 1;
    $newEmail = 'newemail@example.com';
    
    $stmt = $dbh->prepare("UPDATE customers SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $newEmail);
    $stmt->bindParam(':id', $customerId);
    
    $stmt->execute();
    
    echo "<br>Đã cập nhật thông tin khách hàng có ID là 1 thành công<br>";

    // Xoá một khách hàng có id là 5
    $customerId = 5;

    $stmt = $dbh->prepare("DELETE FROM customers WHERE id = :id");
    $stmt->bindParam(':id', $customerId);

    if ($stmt->execute()) {
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            echo "<br>Đã xoá khách hàng có ID là 5 thành công<br>";
        } else {
            echo "<br>Không tìm thấy khách hàng có ID là 5<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi xoá khách hàng: " . $errorInfo[2];
    }

    // Lấy tất cả các khách hàng có email là "example@gmail.com"
    $email = 'example@gmail.com';

    $stmt = $dbh->prepare("SELECT * FROM customers WHERE email = :email");
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($customers) > 0) {
            foreach ($customers as $customer) {
                echo "<br>Khách hàng ID: " . $customer['id'] . ", Tên: " . $customer['name'] . ", Email: " . $customer['email'] . ", Số điện thoại: " . $customer['phone'] . "<br>";
            }
        } else {
            echo "<br>Không tìm thấy khách hàng có email là example@gmail.com<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }

    // Tạo bảng "orders"
    $createOrdersTableQuery = "CREATE TABLE IF NOT EXISTS orders (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        customer_id INT(11),
        total_amount DECIMAL(10, 2),
        order_date DATE,
        FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
    )";
    $dbh->exec($createOrdersTableQuery);
    echo "<br>Đã tạo bảng orders thành công<br>";

    // Thêm một đơn hàng mới vào bảng "orders" cho khách hàng có id là 3
    $customerId = 3;
    $totalAmount = 100.50;
    $orderDate = date('Y-m-d');

    $stmt = $dbh->prepare("INSERT INTO orders (customer_id, total_amount, order_date) VALUES (:customer_id, :total_amount, :order_date)");
    $stmt->bindParam(':customer_id', $customerId);
    $stmt->bindParam(':total_amount', $totalAmount);
    $stmt->bindParam(':order_date', $orderDate);

    if ($stmt->execute()) {
        echo "<br>Thêm đơn hàng thành công<br>";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Lỗi khi thêm đơn hàng: " . $errorInfo[2];
    }
    // Lấy tất cả các đơn hàng của khách hàng có id là 3
    $customerId = 3;

    $stmt = $dbh->prepare("SELECT * FROM orders WHERE customer_id = :customer_id");
    $stmt->bindParam(':customer_id', $customerId);
    
    if ($stmt->execute()) {
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($orders as $order) {
            echo "<br>Đơn hàng ID: " . $order['id'] . ", Khách hàng ID: " . $order['customer_id'] . ", Tổng số tiền: " . $order['total_amount'] . ", Ngày đặt hàng: " . $order['order_date'] . "<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }
    // Lấy danh sách khách hàng và đơn hàng của họ, sử dụng câu lệnh JOIN
    $stmt = $dbh->prepare("SELECT customers.id, customers.name, orders.id AS order_id, orders.total_amount, orders.order_date
    FROM customers
    LEFT JOIN orders ON customers.id = orders.customer_id");

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            echo "<br>Khách hàng ID: " . $row['id'] . ", Tên: " . $row['name'] . ", Đơn hàng ID: " . $row['order_id'] . ", Tổng số tiền: " . $row['total_amount'] . ", Ngày đặt hàng: " . $row['order_date'] . "<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }

    // Lấy danh sách email của khách hàng, sử dụng hàm DISTINCT
    $stmt = $dbh->prepare("SELECT DISTINCT email FROM customers");

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            echo "<br>Email: " . $row['email'] . "<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }

    // Đóng kết nối
    $dbh = null;
} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
?>
