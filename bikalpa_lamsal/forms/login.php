<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uusername = $_POST["username"];
    $password = $_POST["password"];

    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "user12"; // Your database name
    $tableName = "usser"; // Your table name

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check for database connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM $tableName WHERE username = '$uusername'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Username exists, now verify the password
        $row = $result->fetch_assoc();
        $storedPassword = $row["passwordss"];
        if ($password == $storedPassword) {
            // Password is correct
            session_start();
            $_SESSION['loggedin'] = true;
            header('Location: /suman_gyawali/index.html'); // Redirect back to index.html after successful login
            exit();

            // You can redirect to a different page or set a session for the user here
        } else {
            // Password is incorrect
            echo "Incorrect password. Please try again.";
        }
    } else {
        // Username doesn't exist
        echo "Username not found. Please register first.";
    }

    // Close the database connection
    $conn->close();
}
