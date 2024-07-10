<?php
session_start();

$conn = new mysqli( 'localhost', 'root', '', 'music_website' );
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn các bài hát phổ biến
$popularSongs = $conn->query("SELECT * FROM songs ORDER BY created_at DESC LIMIT 5");

// Truy vấn các bài hát mới nhất
$newestSongs = $conn->query("SELECT * FROM songs ORDER BY created_at DESC LIMIT 5");

// Truy vấn các bài hát hot
$hotSongs = $conn->query("SELECT * FROM songs ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Website nghe nhac</title>
  <link rel="icon" href="favicon.ico" mce_href="favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="favicon.ico" mce_href="http://jt.hapboy.xyz/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/reset.css">
  <link rel="stylesheet" href="assets/css/common.css">
  <link rel="stylesheet" href="assets/css/slider.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <style>
    .upload-form-container {
      display: none;
    }
  </style>

</head>
<body>
<!-- Thanh điều hướng -->
<header>
  <div class="container">
    <div class="navbar-header">
      <a href="" class="navbar-brand">
        <img src="assets/images/logo.png" alt="logo">
      </a>
    </div>
    <nav>
      <ul class="nav navbar-nav navbar-link">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="../../category/categories/2.php">Categories</a></li>
        <li><a href="../../category/hits/3.php">Hits</a></li>
        <li><a href="../../category/artist/1.php">Artists</a></li>
        <li><a href="../../category/news/4.php">News</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right navbar-sm">
        <li><input type="text" id="searchInput" class="search-input" placeholder="Tên bài hát / ca sĩ" onkeyup="searchMusic()"></li>
        <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
        <?php if (isset($_SESSION['username'])): ?>
          <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['username']; ?></a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
        <li><a href="../account/login.php">Login</a></li>
        <li><a href="../account/register.php">Register</a></li>
        <?php endif; ?>
      </ul>    
    </nav>
  </div>
</header>
<!-- Đồ thị -->
<div class="container-sm slider-wrap">
  <div class="slider">
    <div class="slider-item-list"></div>
    <div class="slider-dots">
      <div class="slider-dots-wrap"></div>
    </div>
    <div class="slider-arrows">
      <div class="slider-arrows-wrap">
        <span class="slider-arrow slider-arrow-left" onclick="HBSlider.turn(-1)"></span>
        <span class="slider-arrow slider-arrow-right" onclick="HBSlider.turn(1)"></span>
      </div>
    </div>
  </div>
</div>
<!-- Khu vực nội dung chính -->
<div class="container-sm box">
  <!-- Nội dung chính -->
  <div class="main">
    <div class="main-wrap">
      <div class="content-box">
        <!-- Khuyến nghị phổ biến -->
        <div class="hot-recommand">
          <div class="content-header">
            <h2><i class="fa fa-music red"></i>Phổ biến</h2>
            
            <span class="more"><a href="#" onclick="toggleUploadForm()">+</a></span>
          </div>
          <ul class="music-list clearfix" id="musicList">
         <!-- Add more music items here -->
            <?php
              if ($popularSongs->num_rows > 0) {
                  while ($row = $popularSongs->fetch_assoc()) {
                      $songName = $row['song_name'];
                      $artistName = $row['artist_name'];
                      $imagePath = $row['image_file_path']; // Thay 'image_file_path' bằng tên cột thực tế trong cơ sở dữ liệu của bạn
                      $musicPath = $row['music_file_path']; // Thay 'music_file_path' bằng tên cột chứa đường dẫn âm nhạc
                  
                      echo '<li>';
                      echo '<div class="u-cover">';
                      echo '<img src="' . $imagePath . '">';
                      echo '<a title="' . $songName . '" href="' . $musicPath . '" class="msk"></a>';
                      echo '</div>';
                      echo '<p class="dec">';
                      echo '<a title="' . $songName . '" href="' . $musicPath . '">' . $songName . '</a>';
                      echo '</p>';
                      echo '<div class="author">' . $artistName . '</div>'; // Hiển thị tên tác giả
                      echo '</li>';
                  }
              } else {
                  echo '<li>Không có bài hát phổ biến nào.</li>';
              }
              ?>
            <!-- Add more music items here -->
          </ul>         
        </div>

        <!-- Nút mở form Upload -->
        <div class="toggle-upload-form">
            <button onclick="toggleUploadForm()">+</button>
          </div>

          <div class="upload-form-container" id="uploadFormContainer">
            <h2>Tải lên bài hát mới</h2>
            <form id="uploadForm" action="upload/upload.php" method="post" enctype="multipart/form-data">
              <label for="song_name">Tên bài hát:</label>
              <input type="text" id="song_name" name="song_name" required>

              <label for="artist_name">Tên tác giả:</label>
              <input type="text" id="artist_name" name="artist_name" required>

              <label for="category">Thể loại:</label>
              <select id="category" name="category">
                <option value="piano">Piano</option>
                <option value="guitar">Guitar</option>
                <option value="anime">Anime</option>
                <option value="edm">EDM</option>
              </select>

              <label for="image_file">Chọn ảnh:</label>
              <input type="file" id="image_file" name="image_file" accept="image/*" required>

              <label for="music_file">Chọn file nhạc:</label>
              <input type="file" id="music_file" name="music_file" accept="audio/*" required>

              <button type="submit">Upload</button>
            </form>
          </div>
          <!-- End Upload Form Container -->

<!-- Danh sách phân loại -->
<div class="category">
          <div class="content-header">
            <h2><i class="fa fa-music red"></i>Danh sách phân loại</h2>
          </div>
          <div class="row">
            <div class="category-music-list">
              <div class="category-header">🎹 Piano</div>
              <ul>
                <!--Add Songs-->
                <?php
                 $pianoSongs = $conn->query("SELECT * FROM songs WHERE category = 'piano' ORDER BY created_at DESC LIMIT 5");
              
                 if ($pianoSongs->num_rows > 0) {
                   $rank = 1;
                   while ($row = $pianoSongs->fetch_assoc()) {
                     $songName = $row['song_name'];
                     $artistName = $row['artist_name'];
                     $imagePath = $row['image_file_path']; // Thay 'image_file_path' bằng tên cột thực tế trong cơ sở dữ liệu của bạn
                     $musicPath = $row['music_file_path']; // Thay 'music_file_path' bằng tên cột chứa đường dẫn âm nhạc
                     $createdAt = date('d-m', strtotime($row['created_at'])); // Định dạng ngày tháng
              
                     echo '<li class="music-list-item">';
                     echo '<div class="title">';
                     echo '<div class="title_wrap">';
                     echo '<span class="rank">' . $rank . '</span>';
                     echo '<a href="' . $musicPath . '" title="' . $songName . '">' . $songName . '</a>';
                     echo '</div>';
                     echo '</div>';
                     echo '<div class="info">';
                     echo '<span class="date">' . $createdAt . '</span>';
                     echo '<span class="avatar"><img src="' . $imagePath . '"></span>';
                     echo '</div>';
                     echo '</li>';
              
                     $rank++;
                   }
                 } else {
                   echo '<li>Không có bài hát nào.</li>';
                 }
                 ?>
              </ul>
            </div>
            <div class="category-music-list">
              <div class="category-header">🎸 Guitar</div>
              <ul>
                <!--Add Songs-->
                <?php
                  $guitarSongs = $conn->query("SELECT * FROM songs WHERE category = 'guitar' ORDER BY created_at DESC LIMIT 5");
                            
                  if ($guitarSongs->num_rows > 0) {
                    $rank = 1;
                    while ($row = $guitarSongs->fetch_assoc()) {
                      $songName = $row['song_name'];
                      $artistName = $row['artist_name'];
                      $imagePath = $row['image_file_path']; // Thay 'image_file_path' bằng tên cột thực tế trong cơ sở dữ liệu của bạn
                      $musicPath = $row['music_file_path']; // Thay 'music_file_path' bằng tên cột chứa đường dẫn âm nhạc
                      $createdAt = date('d-m', strtotime($row['created_at'])); // Định dạng ngày tháng
                    
                      echo '<li class="music-list-item">';
                      echo '<div class="title">';
                      echo '<div class="title_wrap">';
                      echo '<span class="rank">' . $rank . '</span>';
                      echo '<a href="' . $musicPath . '" title="' . $songName . '">' . $songName . '</a>';
                      echo '</div>';
                      echo '</div>';
                      echo '<div class="info">';
                      echo '<span class="date">' . $createdAt . '</span>';
                      echo '<span class="avatar"><img src="' . $imagePath . '"></span>';
                      echo '</div>';
                      echo '</li>';
                    
                      $rank++;
                    }
                  } else {
                    echo '<li>Không có bài hát nào.</li>';
                  }
                  ?>
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="category-music-list">
              <div class="category-header">🍡 Anime</div>
              <ul>
                <!--Add Songs-->
                <?php
                 $animeSongs = $conn->query("SELECT * FROM songs WHERE category = 'anime' ORDER BY created_at DESC LIMIT 5");
             
                 if ($animeSongs->num_rows > 0) {
                   $rank = 1;
                   while ($row = $animeSongs->fetch_assoc()) {
                     $songName = $row['song_name'];
                     $artistName = $row['artist_name'];
                     $imagePath = $row['image_file_path']; // Thay 'image_file_path' bằng tên cột thực tế trong cơ sở dữ liệu của bạn
                     $musicPath = $row['music_file_path']; // Thay 'music_file_path' bằng tên cột chứa đường dẫn âm nhạc
                     $createdAt = date('d-m', strtotime($row['created_at'])); // Định dạng ngày tháng
             
                     echo '<li class="music-list-item">';
                     echo '<div class="title">';
                     echo '<div class="title_wrap">';
                     echo '<span class="rank">' . $rank . '</span>';
                     echo '<a href="' . $musicPath . '" title="' . $songName . '">' . $songName . '</a>';
                     echo '</div>';
                     echo '</div>';
                     echo '<div class="info">';
                     echo '<span class="date">' . $createdAt . '</span>';
                     echo '<span class="avatar"><img src="' . $imagePath . '"></span>';
                     echo '</div>';
                     echo '</li>';
             
                     $rank++;
                   }
                 } else {
                   echo '<li>Không có bài hát nào.</li>';
                 }
                 ?>
              </ul>
            </div>
            <div class="category-music-list">
              <div class="category-header">⚡️ EDM</div>
              <ul>
                <!--Add Songs-->
                <?php
                 $edmSongs = $conn->query("SELECT * FROM songs WHERE category = 'edm' ORDER BY created_at DESC LIMIT 5");
             
                 if ($edmSongs->num_rows > 0) {
                   $rank = 1;
                   while ($row = $edmSongs->fetch_assoc()) {
                     $songName = $row['song_name'];
                     $artistName = $row['artist_name'];
                     $imagePath = $row['image_file_path']; // Thay 'image_file_path' bằng tên cột thực tế trong cơ sở dữ liệu của bạn
                     $musicPath = $row['music_file_path']; // Thay 'music_file_path' bằng tên cột chứa đường dẫn âm nhạc
                     $createdAt = date('d-m', strtotime($row['created_at'])); // Định dạng ngày tháng
             
                     echo '<li class="music-list-item">';
                     echo '<div class="title">';
                     echo '<div class="title_wrap">';
                     echo '<span class="rank">' . $rank . '</span>';
                     echo '<a href="' . $musicPath . '" title="' . $songName . '">' . $songName . '</a>';
                     echo '</div>';
                     echo '</div>';
                     echo '<div class="info">';
                     echo '<span class="date">' . $createdAt . '</span>';
                     echo '<span class="avatar"><img src="' . $imagePath . '"></span>';
                     echo '</div>';
                     echo '</li>';
             
                     $rank++;
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
  </div>

  <!-- Thanh bên -->
  <div class="sidebar" style="min-height: 1094px">
    <div class="right-module">
      <h4>Newest Songs</h4>
      <ul class="new-artist-songs">
        <!-- add song -->
        <?php
        $newestSongs = $conn->query("SELECT * FROM songs ORDER BY created_at DESC LIMIT 5");
    
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
    <div class="right-module">
      <h4>Hot Songs</h4>
      <ul class="new-artist-songs">
        <!-- add song -->
        <?php
        $newestSongs = $conn->query("SELECT * FROM songs ORDER BY created_at DESC LIMIT 5");
    
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
<!-- Bản quyền dưới cùng -->
<footer>
  <div class="container">
    <div class="copyright">
      <p>Copyright © <span class="update-year">2024</span> Hatties - All Rights Reserved</p>
    </div>
  </div>
</footer>
<!-- JS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/HBSlider.js"></script>
<script src="assets/js/search.js"></script>
<script>
  // Dữ liệu sơ đồ xoay
  var sliderData = [
  {
      title: 'Tên bài hát',
      pic: './storage/slider/01.avif',
      url: './music/1.html'
    },
  
    {
      title: 'Flower Dance',
      pic: './storage/slider/Flower_Dance.jpg',
      url: './music/2.html'
    },  
  ];
  $(function () {
    HBSlider.setConfig({
      autoPlay: true,
      delay: 5
    });
    HBSlider.setItems(sliderData);
    HBSlider.init();
    HBSlider.play();
  });
</script>
<script>
    function toggleUploadForm() {
      var formContainer = document.getElementById('uploadFormContainer');
      if (formContainer.style.display === 'none' || formContainer.style.display === '') {
        formContainer.style.display = 'block';
      } else {
        formContainer.style.display = 'none';
      }
    }
  </script>

</body>
</html>