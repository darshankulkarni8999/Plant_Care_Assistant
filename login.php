<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = sha1($password);

    // Connect to the database
    try {
        $con = mysqli_connect("localhost", "root", "", "plantcare");
        
        if (mysqli_connect_error()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }

        // Check if the user exists
        $query = "SELECT * FROM users WHERE username='$username' AND password='$hashed_password'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) == 1) {
            // User exists, set username in session and redirect to homepage
            $_SESSION['username'] = $username;
            header("Location: http://localhost/homepage.php"); // assuming homepage.php is your homepage
            exit();
        } else {
            echo "Invalid username or password!";
        }
        
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($con);
}
?>