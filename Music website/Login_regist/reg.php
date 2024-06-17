<?php
require 'db/connect.php';
if(isset($_POST['btn-reg'])) {
    echo "<pre>";
    print_r($_POST);
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $email = $_POST['Email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    if(!empty($username)&&!empty($fullname)&&!empty($password)&&!empty($email)&&!empty($address)&&!empty($gender)) {
    echo "<pre>";
    print_r($_POST);

    $sql = "INSERT INTO `dangkytaikhoan` (`fullname`, `username`, `password`, `email`, `address`, `gender`)  VALUE('$fullname', '$username', '$password', '$email', '$address', '$gender') ";

    if($conn->query($sql)===TRUE) {
        echo "Lưu dữ liệu thành công";
    }else {
        echo "Lỗi {$sql}" .$conn->error;
    }
    }else {
        echo "Bạn cần nhập đầy đủ thông tin trước khi đăng ký";
    }
}
echo "<pre>";
print_r($_POST);
?>
