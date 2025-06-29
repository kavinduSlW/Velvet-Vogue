<?php
// filepath: c:\Users\HP\Desktop\Velvet Vogue\login.php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "velvetvogue");
if ($conn->connect_error) {
    echo json_encode(["success"=>false, "message"=>"Database connection failed"]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($data['email']);
$password = $data['password'];

$result = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo json_encode(["success"=>true, "name"=>$user['name'], "email"=>$user['email']]);
        exit;
    }
}
echo json_encode(["success"=>false, "message"=>"Invalid email or password"]);
?>