<?php
session_start();

// Database connection settings
$host = 'localhost';  // Usually 'localhost'
$dbname = 'mosque_db'; // Your database name
$db_username = 'root';    // Your database username
$db_password = '';        // Your database password

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // User's name (Name column in your table)
    $password = $_POST['password']; // User's password
    $role = $_POST['role']; // User's role

    // SQL query to check if the user exists, password is correct, and role matches
    $stmt = $conn->prepare("SELECT UserID, Password, Role, Email, Phone, Address FROM users WHERE Name = ? AND Role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists with the selected role
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $db_role, $email, $phone, $address);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $db_role;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['address'] = $address;

            // Redirect based on role
            if ($db_role == 'Administrator') {
                header("Location: admin/index.html");
            } elseif ($db_role == 'Member') {
                header("Location: member/home.html");
            } else {
                header("Location: guest/index.html");
            }
            exit();
        } else {
            // Incorrect password
            echo "Invalid password.";
        }
    } else {
        // User not found or role mismatch
        echo "No user found with that username and role combination.";
    }

    $stmt->close();
}

$conn->close();
?>
