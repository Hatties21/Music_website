<?php
session_start();
include '../../config/db.php'; // Đảm bảo đường dẫn này đúng

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Categories</title>
  <link rel="stylesheet" href="../../assets/css/reset.css">
  <link rel="stylesheet" href="../../assets/css/common.css">
  <link rel="stylesheet" href="../../assets/css/category.css">
  <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>
<!-- Thanh điều hướng -->
<header>
  <div class="container">
    <div class="navbar-header">
      <a href="" class="navbar-brand">
        <img src="../../assets/images/logo.png" alt="">
      </a>
    </div>
    <nav>
      <ul class="nav navbar-nav navbar-link">
        <li><a href="../../index.php">Home</a></li>
        <li class="active"><a href="../../category/categories/2.php">Categories</a></li>
        <li><a href="../../category/hits/3.php">Hits</a></li>
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
    <div class="img" style="background-image: url('../../storage/avatar/piano.avif')">
      <div class="content">
        <h2>Categories</h2>
        <p>Categories</p>
      </div>
      <div class="mask"></div>
    </div>
  </div>
</div>
<!-- Danh sách category -->
<div class="container-sm box">
  <div class="main">
    <div class="main-wrap">
      <div class="content-box">
        <div class="piano-list">
          <div class="content-header">
            <h2><i class="fa fa-music red"></i>Newest</h2>
          </div>
          <!-- Hiển thị danh sách category -->
          <div class="category-list">
            <h3>Categories</h3>
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                </tr>
              </thead>
              <tbody>
              <?php
              if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                      echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td></tr>";
                  }
              } else {
                  echo "<tr><td colspan='2'>No categories available</td></tr>";
              }
              ?>
              </tbody>
            </table>
          </div>
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
