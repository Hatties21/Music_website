<?php
session_start();

// Kết nối đến CSDL (sử dụng PDO)
$pdo = new PDO('mysql:host=localhost;dbname=music_website', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Thiết lập chế độ báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý upload file nhạc
    if (isset($_FILES["music_file"]) && isset($_FILES["image_file"])) {
        $songName = $_POST['song_name'];
        $artistName = $_POST['artist_name'];
        $category = $_POST['category'];

        // Thư mục lưu trữ file nhạc
        $musicUploadDir = 'storage/ms/';
        if (!file_exists($musicUploadDir)) {
            mkdir($musicUploadDir, 0777, true); // Tạo thư mục nếu chưa tồn tại
        }

        $musicFileName = basename($_FILES["music_file"]["name"]);
        $musicFilePath = $musicUploadDir . $musicFileName;

        // Di chuyển file nhạc vào thư mục lưu trữ
        if (move_uploaded_file($_FILES["music_file"]["tmp_name"], $musicFilePath)) {
            // Thư mục lưu trữ file ảnh
            $imageUploadDir = 'storage/avatar/';
            if (!file_exists($imageUploadDir)) {
                mkdir($imageUploadDir, 0777, true); // Tạo thư mục nếu chưa tồn tại
            }

            $imageFileName = basename($_FILES["image_file"]["name"]);
            $imageFilePath = $imageUploadDir . $imageFileName;

            // Di chuyển file ảnh vào thư mục lưu trữ
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $imageFilePath)) {
                // File nhạc và ảnh đã được lưu thành công, tiếp tục lưu thông tin vào CSDL
                $query = "INSERT INTO songs (song_name, artist_name, category, music_file_path, image_file_path) 
                          VALUES (:song_name, :artist_name, :category, :music_file_path, :image_file_path)";
                $statement = $pdo->prepare($query);
                $statement->bindParam(':song_name', $songName);
                $statement->bindParam(':artist_name', $artistName);
                $statement->bindParam(':category', $category);
                $statement->bindParam(':music_file_path', $musicFilePath);
                $statement->bindParam(':image_file_path', $imageFilePath);

                try {
                    $pdo->beginTransaction();
                    $statement->execute();
                    $pdo->commit();
                    echo "Upload file nhạc và ảnh thành công";
                    // Chuyển hướng về trang chủ sau khi upload thành công
                    header("Location: ../index.php");
                    exit();
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    echo "Có lỗi xảy ra khi lưu thông tin bài hát: " . $e->getMessage();
                }
            } else {
                echo "Có lỗi xảy ra khi upload file ảnh.";
            }
        } else {
            echo "Có lỗi xảy ra khi upload file nhạc.";
        }
    } else {
        echo "Vui lòng chọn cả file nhạc và file ảnh để upload.";
    }
}


// Lấy danh sách các bài hát từ cơ sở dữ liệu
$songsQuery = "SELECT * FROM songs";
$songsResult = $conn->query($songsQuery);

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Successful</title>
</head>
<body>
    <h2>Thông tin các bài hát đã được tải lên:</h2>
    <ul>
        <?php
        if ($songsResult->num_rows > 0) {
            while ($row = $songsResult->fetch_assoc()) {
                echo "<li>Bài hát: " . $row['song_name'] . " - Tác giả: " . $row['artist_name'] . " - Thể loại: " . $row['category'] . "</li>";
            }
        } else {
            echo "Không có bài hát nào được tải lên.";
        }
        ?>
    </ul>
</body>
</html>
