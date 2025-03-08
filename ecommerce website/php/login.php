<?php
session_start();
$host = "localhost";  // Change if needed
$user = "root";       // Your DB username
$pass = "";           // Your DB password
$dbname = "users_db"; // Database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encrypt password before checking

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        echo json_encode(["success" => true, "message" => "Login successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid username or password."]);
    }
}

$conn->close();
?>
