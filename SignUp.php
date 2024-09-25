<?php
// Database connection details (replace with your actual credentials)
$servername = "mysql6013.site4now.net";
$username = "db_aad944_waterlk";
$password = "TheRealEkanem16@";
$dbname = "waterlk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $location = $_POST['location'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
}

// Sanitize input (prevent SQL injection)
$full_name = $conn->real_escape_string($full_name);
$email = $conn->real_escape_string($email);
$phone = $conn->real_escape_string($phone);
$address = $conn->real_escape_string($address);
$location = $conn->real_escape_string($location);
$password = $conn->real_escape_string($password);
$confirm_password = $conn->real_escape_string($confirm_password);

// Basic validation (you'll likely want to add more robust validation)
if ($password != $confirm_password) {
  echo "Passwords do not match.";
} else {
  // Hash the password securely
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert new user into the database
  $sql = "INSERT INTO users (full_name, email, phone, address, location, password) VALUES ('$full_name', '$email', '$phone', '$address', '$location', '$hashed_password')";

  if ($conn->query($sql) === TRUE) {
    echo "Account created successfully!";
    header("Location: login.html");
  } else {
    echo "Error creating account: " . $conn->error;
  }
}

$conn->close();
?>