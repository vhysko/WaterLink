<?php
// Database connection details (replace with your actual credentials)
$servername = "servername";
$username = "username";
$password = "password";
$dbname = "database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Sanitize email input (prevent SQL injection)
    $email = $conn->real_escape_string($email);

    // Check if email exists in the database
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, generate reset token and store in database
        $reset_token = bin2hex(random_bytes(32)); // Generate a secure token

        // Update the user's record with the reset token and expiry time (e.g., 1 hour from now)
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $update_sql = "UPDATE users SET reset_token = '$reset_token', reset_token_expires = '$expiry_time' WHERE email = '$email'";
        $conn->query($update_sql);

        // Send reset email using mail() function
        $reset_link = "https://waterlink.com/reset_password.php?token=$reset_token";
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        $headers = "From: luckyares19@yourdomain.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Error sending email. Please try again later.";
        }
    } else {
        echo "Email not found.";
    }
}

$conn->close();
?>