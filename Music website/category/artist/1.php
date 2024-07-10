<?php
session_start();
include '../../config/db.php'; // Đảm bảo đường dẫn này đúng

// Xử lý thêm nghệ sĩ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_artist'])) {
    $name = $_POST['name'];

    // Validate dữ liệu
    if (empty($name)) {
        $_SESSION['error_message'] = "Artist name is required";
    } elseif (!preg_match("/^[a-zA-Z \&\-]+$/", $name)) {
        $_SESSION['error_message'] = "Artist name can only have letters, spaces, '&' and '-'";
    } else {
        // Thực hiện thêm vào cơ sở dữ liệu
        $query = "INSERT INTO artist (name) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Artist added successfully";
        } else {
            $_SESSION['error_message'] = "Failed to add artist";
        }
        $stmt->close();
    }

    // Redirect để tránh gửi lại dữ liệu khi người dùng làm mới trang
    header("Location: ../../category/artist/1.php");
    exit();
}

// Xử lý xoá nghệ sĩ
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM artist WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Artist deleted successfully";
    } else {
        $_SESSION['error_message'] = "Failed to delete artist";
    }

    // Redirect để tránh gửi lại dữ liệu khi người dùng làm mới trang
    header("Location: ../../category/artist/1.php");
    exit();
}

// Lấy danh sách các nghệ sĩ từ cơ sở dữ liệu
$sql = "SELECT * FROM artist";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Artists</title>
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
            <li><a href="../../category/categories/2.php">Categories</a></li>
            <li><a href="../../category/hits/3.php">Hits</a></li>
            <li class="active"><a href="../../category/artist/1.php">Artists</a></li>
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

<div class="container-sm category-header-wrap">
<div class="category-header-banner">
    <div class="img" style="background-image: url('../../storage/avatar/artist.avif')">
        <div class="content">
            <h2>Artists</h2>
            <p>Artist</p>
        </div>
        <div class="mask"></div>
    </div>
</div>
</div>

<div class="container-sm box">
<div class="main">
    <div class="main-wrap">
        <div class="content-box">
            <div class="piano-list">
                <div class="content-header">
                    <h2><i class="fa fa-music red"></i>Newest</h2>
                </div>
                <!-- Hiển thị danh sách nghệ sĩ -->
                <div class="artist-list">
                    <h3>Artists</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td><a href='artist.php?action=delete&id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this artist?\")'>Delete</a></td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No artists available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Form thêm nghệ sĩ -->
                <div class="add-artist-form">
                    <h3>Add New Artist</h3>
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <p style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>
                    <form action="artist.php" method="POST">
                        <input type="text" name="name" placeholder="Artist Name" required>
                        <button type="submit" name="add_artist">Add Artist</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

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
