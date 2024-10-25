<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: index.html"); // Change this to your desired redirect page
exit();
?>
