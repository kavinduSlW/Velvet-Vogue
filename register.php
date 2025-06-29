<?php
// filepath: c:\Users\HP\Desktop\Velvet Vogue\register.php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "velvetvogue");
if ($conn->connect_error) {
    echo json_encode(["success"=>false, "message"=>"Database connection failed"]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);
$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$result = $conn->query("SELECT id FROM users WHERE email='$email'");
if ($result->num_rows > 0) {
    echo json_encode(["success"=>false, "message"=>"Email already registered"]);
    exit;
}
$conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
echo json_encode(["success"=>true]);
?>