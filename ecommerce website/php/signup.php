<?php
header("Content-Type: application/json");

// Allow all origins (Replace "*" with a specific domain if needed)
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}



include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        die(json_encode(["success" => false, "message" => "All fields are required!"]));
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Signup successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
