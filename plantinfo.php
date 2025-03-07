<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fbe7; /* Light yellow */
            color: #37474f; /* Dark blue-grey */
            padding: 20px;
        }
        .plant-info {
            background-color: #ffffff; /* White */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .plant-info:hover {
            transform: translateY(-5px); /* Move up slightly on hover */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Add shadow on hover */
        }
        .plant-info h2 {
            color: #4caf50; /* Green */
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .plant-info p {
            color: #333333; /* Dark grey */
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <?php
    if(isset($_GET['option'])) {
        $selectedOption = $_GET['option'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "plantcare";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to retrieve information based on the selected option
        $sql = "SELECT DISTINCT * FROM plantinformation WHERE plant = '$selectedOption'";
        $result = $conn->query($sql);

        if (!$result) {
            // Query failed
            echo "Error: " . $conn->error;
        } elseif ($result->num_rows > 0) {
            // Fetch and display results
            while($row = $result->fetch_assoc()) {
                echo "<div class='plant-info'>";
                echo "<h2>" . $row["plant"]. "</h2>";
                echo "<p><strong>Planting Method:</strong> " . $row["plantingMethod"]. "</p>";
                echo "<p><strong>Temperature:</strong> " . $row["temperature"]. "</p>";
                echo "<p><strong>Growing Method:</strong> " . $row["growingmethod"]. "</p>";
                echo "<p><strong>Watering:</strong> " . $row["watering"]. "</p>";
                echo "<p><strong>Fertilizer:</strong> " . $row["fertilizers/mannure"]. "</p>";
                echo "<p><strong>Harvesting:</strong> " . $row["harvesting"]. "</p>";
                echo "<p><strong>Uses:</strong> " . $row["uses"]. "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No results found for $selectedOption</p>";
        }

        $conn->close();
    } else {
        echo "<p>No option selected.</p>";
    }
    ?>
</body>
</html>