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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Sanitize input (prevent SQL injection)
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Query the database to check credentials
    $sql = "SELECT id, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $user_id = $row['id']; // Get the user ID

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Successful login

            // Handle "remember me" functionality
            if ($remember) {
                // Set a cookie with user ID and a unique token
                $token = bin2hex(random_bytes(32));
                setcookie('remember_user_id', $user_id, time() + (86400 * 30), '/'); // Cookie expires in 30 days
                setcookie('remember_token', $token, time() + (86400 * 30), '/');

                // Store the token
                $update_sql = "UPDATE users SET remember_token = '$token' WHERE id = $user_id";
                $conn->query($update_sql);
            }

            echo "Login successful!";
            header("Location: user.html");
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
}

$conn->close();
?>