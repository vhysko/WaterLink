<?php
user=postgres.kdrbheygnrkgjnpnkwji password=[hwbA_t959WPe_Ud] host=aws-0-eu-central-1.pooler.supabase.com port=6543 dbname=postgres
// Database connection details
//$servername = "mysql6013.site4now.net";
//$username = "db_aad944_waterlk";
//$password = "TheRealEkanem16@";
//$dbname = "waterlk";

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

// Get data from the form
$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];

// Insert data into the database
$sql = "INSERT INTO bookings (full_name, phone, email, address)
        VALUES ('$full_name', '$phone', '$email', '$address')";

if ($conn->query($sql) === TRUE) {
    // Send email notification
    $to = $email;
    $subject = "Booking Confirmation";
    $message = "Thank you for your booking, $full_name!\n\nYour booking was successful.";
    $headers = "From: goodluckiyem@gmail.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Booking successful! A confirmation email has been sent.";
        header("Location: confirmed_book.html");
    } else {
        echo "Booking successful, but there was an error sending the email.";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
