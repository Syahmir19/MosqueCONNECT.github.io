<?php
// Include the database connection file
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];      // New field: Phone
    $address = $_POST['address'];  // New field: Address
    $password = $_POST['password'];
    $role = $_POST['role']; // This will be "member" from the hidden input field

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert the user with the new fields
    $sql = "INSERT INTO users (Name, Email, Phone, Address, password, Role) 
            VALUES ('$username', '$email', '$phone', '$address', '$hashed_password', '$role')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "New user created successfully!";
        header('Location: login.html'); // Redirect to login page after signup
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>
