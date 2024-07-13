<?php
session_start();

// Define valid credentials (in a real application, retrieve these from a database)
$valid_email = "user@example.com";
$valid_password = "password";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate credentials
    if ($email == $valid_email && $password == $valid_password) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: index.php"); // Redirect to protected page
        exit();
    } else {
        // Invalid credentials
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: login.html");
        exit();
    }
} else {
    echo "Invalid request method.";
}
?>
