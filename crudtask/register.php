<?php

$success = false; 

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$phoneNo = $_POST['phoneNo'];
$Address = $_POST['Address'];
$pinCode = $_POST['pinCode'];
$dob = $_POST['dob'];
$age = $_POST['age'];


if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword) || empty($phoneNo) || empty($Address) || empty($pinCode) || empty($dob)) {
    echo json_encode(array("success" => false, "message" => "Please fill in all the fields"));
    exit;
} 

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array("success" => false, "message" => "Invalid email format!"));
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(array("success" => false, "message" => "Passwords do not match!"));
    exit;
} 
if (!preg_match('/^\d{10}$/', $phoneNo)) {
    echo json_encode(array("success" => false, "message" => "Invalid phone number format! Please enter 10 digits."));
    exit;
}

// Create a database connection
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "crudtask";
$conn = mysqli_connect($servername, $username, $dbpassword, $dbname);

if (!$conn) {
    echo json_encode(array("success" => false, "message" => "Database connection error"));
    exit;
}

$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(array("success" => false, "message" => "Email already exists, please use another email!"));
    $stmt->close();
    $conn->close();
    exit;
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$sql = "INSERT INTO users (first_name, last_name, email, password, ph_no, address, pin_code, dob, age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $firstName, $lastName, $email, $hashedPassword, $phoneNo, $Address, $pinCode, $dob, $age);
$success = $stmt->execute();

$stmt->close();
$conn->close();

if ($success) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => "Registration failed"));
}
?>
