<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $favorite_color = $_POST["favorite_color"];
    $favorite_pet = $_POST["favorite_pet"];
    $school = $_POST["school"];

    // Validate password and confirm password
    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    // Hash the password
    $hashed_password = sha1($password);

    // Connect to the database
    try {
        $con = mysqli_connect("localhost", "root", "", "plantcare");
        
        if (mysqli_connect_error()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }

        // Check if the username already exists
        $check_query = "SELECT * FROM users WHERE username='$username'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Username already exists!');</script>";
            return 0;
        }

        // Insert new user data into the database
        $insert_query = "INSERT INTO users (username, password, email, favorite_color, favorite_pet, school) 
                         VALUES ('$username', '$hashed_password', '$email', '$favorite_color', '$favorite_pet', '$school')";
        
        mysqli_query($con, $insert_query);

        if (mysqli_error($con)) {
            printf(mysqli_error($con));
        } else {
            printf("Saved your details successfully");

            // Store username in session
            $_SESSION['username'] = $username;

            // Redirect to homepage
            header("Location: http://localhost/homepage.php");
            exit();
        }
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($con);
}
?>