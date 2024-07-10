<?php
session_start();

$conn = new mysqli( 'localhost', 'root', '', 'music_website' );
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$hotSongs = $conn->query("SELECT * FROM songs ORDER BY created_at DESC LIMIT 5");

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Hits </title>
  <link rel="stylesheet" href="../../assets/css/reset.css">
  <link rel="stylesheet" href="../../assets/css/common.css">
  <link rel="stylesheet" href="../../assets/css/category.css">
  <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
</head>
<body>
<header>
    <!-- Thanh điều hướng -->
  <div class="container">
    <div class="navbar-header">
      <a href="" class="navbar-brand">
        <img src="../../assets/images/logo.png" alt="">
      </a>
    </div>
    <nav>
      <ul class="nav navbar-nav navbar-link">
        <li><a href="../../index.php">Home</a></li>
        <li><a href="../../category/categories/2.php">Categories</a></li>
        <li class="active"><a href="../../category/hits/3.php">Hits</a></li>
        <li><a href="../../category/artist/1.php">Artists</a></li>
        <li><a href="../../category/news/4.php">News</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right navbar-sm">
        <li><input type="text" id="searchInput" class="search-input" placeholder="Tên bài hát / ca sĩ" onkeyup="searchMusic()"></li>
        <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
        <?php if (isset($_SESSION['username'])): ?>
          <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['username']; ?></a></li>
          <li><a href="../logout.php">Logout</a></li>
        <?php else: ?>
        <li><a href="../account/login.php">Login</a></li>
        <li><a href="../account/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
<!-- Thông tin đầu -->
<div class="container-sm category-header-wrap">
  <div class="category-header-banner">
    <div class="img" style="background-image: url('../../storage/avatar/hits.jpg')">
      <div class="content">
        <h2>Hits</h2>
        <p>Hits</p>
      </div>
      <div class="mask"></div>
    </div>
  </div>
</div>
<!-- Danh sách âm nhạc -->
<div class="container-sm box">
  <div class="main">
    <div class="main-wrap">
      <div class="content-box">
        <div class="piano-list">
          <div class="content-header">
            <h2><i class="fa fa-music red"></i>Newest</h2>
          </div>
          <ul class="music-list clearfix">
          <?php  
        if ($newestSongs->num_rows > 0) {
          while ($row = $newestSongs->fetch_assoc()) {
            $songName = $row['song_name'];
            $artistName = $row['artist_name'];
            $imagePath = $row['image_file_path']; // Thay 'image_file_path' bằng tên cột thực tế trong cơ sở dữ liệu của bạn
            $musicPath = $row['music_file_path']; // Thay 'music_file_path' bằng tên cột chứa đường dẫn âm nhạc
    
            echo '<li class="artist-song">';
            echo '<div class="avatar">';
            echo '<img src="' . $imagePath . '">';
            echo '</div>';
            echo '<div class="info">';
            echo '<h3>' . $songName . '</h3>';
            echo '<p>' . $artistName . '</p>';
            echo '</div>';
            echo '<a href="' . $musicPath . '" title="' . $songName . '" class="cover-link"></a>';
            echo '</li>';
          }
        } else {
          echo '<li>Không có bài hát nào.</li>';
        }
        ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Bản quyền dưới cùng -->
<footer>
  <div class="container">
    <div class="copyright">
      <p>Copyright © <span class="update-year">2024</span> Hatties - All Rights Reserved</p>
    </div>
  </div>
</footer>
<script src="assets/js/search.js"></script>
</body>
</html>