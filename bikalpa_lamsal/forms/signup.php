<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $fname = $_POST["ffname"];
    $lname = $_POST["llname"];
    $uusernames = $_POST["uusername"];
    $passwordd = $_POST["passwordd"];
    $confirmPassword = $_POST["confirmPassword"];

    // Check if passwords match
    if ($passwordd !== $confirmPassword) {
        echo "Passwords do not match. Please try again.";
    } else {
        // Passwords match, proceed with registration
        // Hash the password and insert into the database
       // $hashedPassword = password_hash($passwordd, PASSWORD_DEFAULT);

        // Database connection parameters
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
        // Check if the username already exists in the database
        $checkQuery = "SELECT * FROM $tableName WHERE username = '$uusernames'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "Username already exists. Please choose a different username.";
        } else {
            // Username is unique, proceed with registration
            // SQL query to insert a new user into the database
            // SQL query to insert a new user into the database
            $insertQuery = "INSERT INTO $tableName (first_name, last_name, username, passwordss) 
VALUES ('$fname', '$lname', '$uusernames', '$passwordd')";


            if ($conn->query($insertQuery) === TRUE) {
                echo "Registration successful!";
                session_start();
                $_SESSION['loggedin'] = true;
                header('Location: /suman_gyawali/index.html'); // Redirect back to index.html after successful login
                exit();
                // In the signup code

            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    }
}
