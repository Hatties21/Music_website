<?php
session_start();

// Kết nối đến MySQL
$conn = new mysqli( 'localhost', 'root', '', 'music_website' );

// Kiểm tra kết nối
if ( $conn->connect_error ) {
    die( 'Connection failed: ' . $conn->connect_error );
}

// Xử lý form đăng ký khi người dùng submit
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $username = $_POST[ 'username' ];
    $password = $_POST[ 'password' ];

    // Bảo vệ dữ liệu trước khi thêm vào cơ sở dữ liệu
    $username = mysqli_real_escape_string( $conn, $username );
    // mã hoá mật khẩu để lưu vào cơ sở dữ liệu
    $hashed_password = password_hash( $password, PASSWORD_DEFAULT );

    // Truy vấn kiểm tra xem username đã tồn tại chưa
    $check_username_query = "SELECT * FROM users WHERE username='$username'";
    $check_username_result = $conn->query( $check_username_query );

    if ( $check_username_result->num_rows > 0 ) {
        $error_message = 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!';
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $insert_user_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if ( $conn->query( $insert_user_query ) === TRUE ) {
            $success_message = "Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a>.";
        } else {
            $error_message = 'Đã xảy ra lỗi trong quá trình đăng ký! ' . $conn->error;
        }
    }
}

// Đóng kết nối
$conn->close();
?>

<a></a>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Đăng nhập</title>
    <link href='//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
    <script src='//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <!-- Latest compiled and minified CSS -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css'>

    <!-- jQuery library -->
    <script src='https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js'></script>

    <!-- Popper JS -->
    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>

    <!-- Latest compiled JavaScript -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js'></script>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'
        integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.1/css/all.css'
        integrity='sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP' crossorigin='anonymous'>
</head>

<body>
    <div class='container h-100' style='background-color:rgb(255, 255, 255)'>
        <div class='d-flex justify-content-center h-100'>
            <div class='user_card'>
                <div class='d-flex justify-content-center'>
                    <div class='brand_logo_container'>
                        <h1 style='text-align:center;color:darkorange'>Đăng ký tài khoản</h1>
                        <br>
                    </div>
                </div>
                <div class='d-flex justify-content-center'>
                    <?php
if ( isset( $error_message ) ) {
    echo "<p>$error_message</p>";
} elseif ( isset( $success_message ) ) {
    echo "<p>$success_message</p>";
}
?>
                </div>
                <div class='d-flex justify-content-center form_container'>
                    <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='POST'>
                        <div class='input-group mb-3'>
                            <div class='input-group-append'>
                                <span class='input-group-text'><i class='fas fa-user'></i></span>
                            </div>
                            <input type='text' name='username' id='username' class='form-control input_user' value=''
                                placeholder='Username'>
                        </div>
                        <div class='input-group mb-2'>
                            <div class='input-group-append'>
                                <span class='input-group-text'><i class='fas fa-key'></i></span>
                            </div>
                            <input type='password' name='password' id='password' class='form-control input_pass'
                                value='' placeholder='Password'>
                        </div>
                        <div class='form-group'>
                            <div class='custom-control custom-checkbox'>
                                <input type='checkbox' class='custom-control-input' id='customControlInline'>
                                <label class='custom-control-label' for='customControlInline'>Đồng ý các điều
                                    khoản!</label>
                            </div>
                        </div>
                        <div class='d-flex justify-content-center mt-3 login_container'>
                            <button type='submit' name='submit' class='btn btn-warning' class='btn login_btn'>Đăng
                                ký</button>
                        </div>
                    </form>
                </div>
                <div class='mt-4'>
                    <div class='d-flex justify-content-center links'>
                        Nếu đã có tài khoản? <a href='login.php'>Đăng nhập ngay!</a>
                    </div>
                    <div class='d-flex justify-content-center links'>
                        <a href='#'>Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>