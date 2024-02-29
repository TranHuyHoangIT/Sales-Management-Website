<?php
// Kết nối đến cơ sở dữ liệu
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'thi';

$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Kiểm tra lỗi kết nối
if (!$connection) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Xử lý yêu cầu đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form đăng nhập
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Truy vấn kiểm tra người dùng
    $query = "SELECT * FROM Users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    // Kiểm tra số lượng bản ghi trả về
    if (mysqli_num_rows($result) == 1) {
        // Đăng nhập thành công
        echo "Đăng nhập thành công!";
        header('Location: index.php');

    } else {
        // Đăng nhập thất bại
        echo "Đăng nhập thất bại!";
        header('Location: dangnhap.php');

    }
}
?>