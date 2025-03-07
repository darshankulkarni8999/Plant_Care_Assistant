<?php
session_start(); // Resume the session

// Check if username is received from the previous session
if(isset($_SESSION['username'])) {
    // Store the username in a variable
    $username = $_SESSION['username'];
} else {
    // If username is not received, redirect user to login page
    header("Location: http://localhost/login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "plantcare";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle posting a new comment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    
    // Insert the new comment into the database
    $sql = "INSERT INTO comments (username, content) VALUES ('$username', '$content')";
    if ($conn->query($sql) === TRUE) {
        // Return the new comment as a response
        echo "<div>" . $username . ": " . $content . "</div>";
        exit(); // Terminate further execution after sending response
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch existing comments from the database
$sql_select = "SELECT * FROM comments WHERE 1";
$result = $conn->query($sql_select);

$comments = array();
if ($result) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Forum</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f9f4;
        margin: 0;
        padding: 0;
        color: #333;
        background-image: url('https://www.transparenttextures.com/patterns/asfalt-light.png');
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        margin-top: 30px;
        font-size: 36px;
        position: relative;
        font-family: 'Poppins', sans-serif;
    }

    h1::after {
        content: '';
        display: block;
        width: 60px;
        height: 6px;
        background-color: #2c3e50;
        margin: 10px auto 0;
        border-radius: 3px;
    }

    #forum {
        margin: 20px auto;
        max-width: 700px;
        padding: 25px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    #forum::before, #forum::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        z-index: -1;
    }

    #forum::before {
        width: 120px;
        height: 120px;
        background: #c8e6c9;
        top: -40px;
        left: -40px;
    }

    #forum::after {
        width: 140px;
        height: 140px;
        background: #a5d6a7;
        bottom: -50px;
        right: -50px;
    }

    textarea {
        display: block;
        width: 100%;
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        resize: vertical;
        background-color: #f8f8f8;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        outline: none;
    }

    button {
        display: block;
        width: 100%;
        padding: 15px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    button:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    button:active {
        background-color: #1e7e34;
        transform: translateY(1px);
    }

    #posts {
        margin-top: 30px;
    }

    .post {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #ffffff;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .post::before, .post::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        z-index: -1;
    }

    .post::before {
        width: 60px;
        height: 60px;
        background: #e8f5e9;
        top: -10px;
        left: -10px;
    }

    .post::after {
        width: 80px;
        height: 80px;
        background: #c8e6c9;
        bottom: -15px;
        right: -15px;
    }

    .post .username {
        font-weight: bold;
        color: #007bff;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .post .content {
        color: #555;
        font-size: 16px;
    }

    /* Plant-themed accents */
    .plant-accent {
        position: absolute;
        background: url('https://image.shutterstock.com/image-vector/hand-drawn-leaves-branches-seamless-260nw-1525893923.jpg') no-repeat center center;
        background-size: cover;
        opacity: 0.2;
    }

    .plant-accent.top-left {
        top: 0;
        left: 0;
        width: 150px;
        height: 150px;
    }

    .plant-accent.bottom-right {
        bottom: 0;
        right: 0;
        width: 150px;
        height: 150px;
    }

    /* Additional decorations */
    .leaf {
        background: url('https://image.shutterstock.com/image-vector/hand-drawn-leaf-vector-illustration-260nw-1828910801.jpg') no-repeat center center;
        background-size: contain;
        opacity: 0.1;
        position: absolute;
        z-index: -1;
    }

    .leaf.one {
        top: -30px;
        left: -30px;
        width: 200px;
        height: 200px;
    }

    .leaf.two {
        bottom: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
    }

    .leaf.three {
        top: 50%;
        left: 50%;
        width: 100px;
        height: 100px;
        transform: translate(-50%, -50%);
    }
</style>

<body>
    <h1>Community Forum</h1>
    
    <div id="forum">
        <textarea id="post-content" placeholder="Write your post..."></textarea>
        <button onclick="post()">Post</button>
        <div id="posts">
            <?php
                // Display existing comments
                foreach ($comments as $comment) {
                    echo "<div>" . $comment['username'] . ": " . $comment['content'] . "</div>";
                }
            ?>
        </div>
    </div>

    <script>
        // Initialize loggedInUser with the username received from the previous session
        let loggedInUser = "<?php echo $username ?>";

        function post() {
            const content = document.getElementById('post-content').value;

            // Send the post data to the same page
            fetch('<?php echo $_SERVER["PHP_SELF"]; ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'content=' + encodeURIComponent(content)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // For demonstration purposes
                // For demonstration, simply display the post on the frontend
                const postsContainer = document.getElementById('posts');
                const postElement = document.createElement('div');
                postElement.innerHTML = data; // The response from the server already includes username and content
                postsContainer.prepend(postElement); // Prepend the new post to show it at the top
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>