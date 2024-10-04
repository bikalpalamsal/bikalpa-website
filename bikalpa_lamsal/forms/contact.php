<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form and sanitize it
    $name = $_POST["Name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Database connection parameters
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "user12"; // Your database name
    $tableName = "message"; // Your table name

    // Create a database connection using prepared statements
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check for database connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepared statement to prevent SQL injection
    $insertQuery = $conn->prepare("INSERT INTO $tableName (Namee, email, subjectt, messagee) VALUES (?, ?, ?, ?)");
    
    // Bind parameters to the prepared statement
    $insertQuery->bind_param("ssss", $name, $email, $subject, $message);
    $response = ["status" => "", "message" => ""];

    if ($insertQuery->execute()) {
        $response["status"] = "success";
        $response["message"] = "Your message has been sent. Thank you!";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error sending the message. Please try again.";
    }
    
    header('Content-Type: application/json'); // Set header to JSON type
    echo json_encode($response);
    
    // Close the prepared statement and the database connection
    $insertQuery->close();
    $conn->close();
    exit(); // Add this line to stop further execution
}
?>