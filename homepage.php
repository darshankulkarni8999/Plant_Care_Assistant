<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            color: #34495e; /* Dark blue-gray text color */
        }

        header {
            background-color: #27ae60; /* Dark green */
            color: #ecf0f1; /* Light gray text color */
            text-align: center;
            padding: 20px;
        }

        .toolbar {
            background-color: #2ecc71; /* Light green */
            padding: 10px 0;
            text-align: center;
        }

        .options {
            display: inline-block;
            margin: 0 20px;
        }

        .options a {
            text-decoration: none;
            color: #34495e; /* Dark blue-gray text color */
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease; /* Added color transition */
            background-color: #27ae60; /* Dark green */
        }

        .options a:hover {
            background-color: #2ecc71; /* Light green on hover */
            color: #ecf0f1; /* Light gray text color */
        }

        main {
            padding: 20px;
            margin-bottom: 60px; /* Adjust as per footer height */
        }

        footer {
            background-color: #27ae60; /* Dark green */
            color: #ecf0f1; /* Light gray text color */
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* Keyframe animation for background image */
        @keyframes changeBackground {
            0% { background-image: url('imag1.jpg'); }
            25% { background-image: url('image6.jpg'); }
            50% { background-image: url('image3.jpg'); }
            75% { background-image: url('image8.jpg'); }
            100% { background-image: url('image5.jpg'); }
        }

        body {
            animation: changeBackground 20s infinite; /* Change every 20 seconds */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Adjust text color for About Us section */
        #about-us {
            color: #ffffff; /* White text color */
        }
    </style>
</head>
<body>

<header>
<?php
session_start(); // Resume the session
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Welcome, $username!";
} else {
    // Redirect user to login page if not logged in
    header("Location: http://localhost/login.php");
    exit();
}
?>
    <h1>Welcome to Plant Care Assistant Website</h1>
    <p>Discover all you need to know about Plants!</p>
</header>
<div class="toolbar">
    <div class="options">
        <a href="plant-selection.html">Plant Selection</a>
    </div>
    <div class="options">
        <a href="fertilizerSelection.html">Fertilizer Preparation</a>
    </div>
    <div class="options">
        <a href="diseaseDetection.html">Disease Management</a>
    </div>
    <div class="options">
        <?php
            if(isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo "<a href='community-forum.php?username=$username'>Community Forum</a>";
            } else {
                // Redirect user to login page if not logged in
                header("Location: http://localhost/login.php");
                exit();
            }
        ?>
    </div>
    </div>
</div>
<main>
    <section id="about-us">
        <h2>About Us</h2>
        <p>Welcome to Plant Care Assistant! We are dedicated to providing you with comprehensive information and resources to help you take care of your plants effectively. Whether you're a seasoned gardener or just starting out, our website offers valuable insights into plant selection, fertilizer preparation, disease management, and a vibrant community forum where you can connect with fellow enthusiasts and experts. Explore our site to enhance your plant care knowledge and grow thriving gardens!</p>
        <p>Our mission is to empower individuals to cultivate healthy and beautiful plants by providing expert guidance and fostering a supportive community of plant lovers. We believe that everyone deserves to experience the joy of successful gardening, and we're here to support you every step of the way.</p>
    </section>
</main>
<footer>
    <p>&copy; 2024 Gardening Website. All rights reserved.</p>
</footer>
</body>
</html>