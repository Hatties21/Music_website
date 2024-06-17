<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Xử lý dữ liệu từ form
$user = $_POST['username'];
$pass = $_POST['password'];

// Kiểm tra xem các trường dữ liệu có được nhập đầy đủ không
if(empty($user) || empty($pass)) {
    die("Vui lòng nhập tên đăng nhập và mật khẩu");
}

// Sử dụng câu lệnh chuẩn bị để tránh SQL Injection
$sql = "SELECT * FROM user WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả trả về từ cơ sở dữ liệu
if ($result->num_rows > 0) {
    // Đăng nhập thành công
    echo "Đăng nhập thành công!";
} else {
    // Đăng nhập thất bại
    echo "Sai tên đăng nhập hoặc mật khẩu!";
}

// Đóng câu lệnh và kết nối
$stmt->close();
$conn->close();
?>