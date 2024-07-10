<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>News </title>
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
        <li><a href="../../category/hits/3.php">Hits</a></li>
        <li><a href="../../category/artist/1.php">Artists</a></li>
        <li class="active"><a href="../../category/news/4.php">News</a></li>
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
    <div class="img" style="background-image: url('../../storage/avatar/news.jpg')">
      <div class="content">
        <h2>News</h2>
        <p>News</p>
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
            <h2><i class="fa fa-music red"></i>About</h2>
          </div>
          <ul class="music-list clearfix">
    <li>
        <div class="title">
            <div class="title_wrap">
                <span class="rank">1</span>
                <a href="#" title="Giới thiệu">Giới thiệu</a>
            </div>
        </div>
        <div class="info">
            <span class="date">-</span>
            <span class="avatar"><img src="../../assets/images/introduction.jpg"></span>
        </div>
    </li>
    <!-- Các mục tin tức sẽ được thêm vào đây -->
    <li>
        <div class="title">
            <div class="title_wrap">
                <span class="rank">2</span>
                <a href="#" title="Tiêu đề bài viết 1">Tiêu đề bài viết 1</a>
            </div>
        </div>
        <div class="info">
            <span class="date">Ngày tháng năm</span>
            <span class="avatar"><img src="../../storage/avatar/Flower_Dance.jpg"></span>
        </div>
    </li>
    <li>
        <div class="title">
            <div class="title_wrap">
                <span class="rank">3</span>
                <a href="#" title="Tiêu đề bài viết 2">Tiêu đề bài viết 2</a>
            </div>
        </div>
        <div class="info">
            <span class="date">Ngày tháng năm</span>
            <span class="avatar"><img src="../../storage/avatar/hits.jpg"></span>
        </div>
    </li>
    <!-- Thêm các mục tin tức khác vào đây -->
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