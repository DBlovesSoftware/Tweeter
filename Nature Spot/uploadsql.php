<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nature Spotter Upload</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { margin: 20px auto; width: 50%; }
        .btn { padding: 10px 20px; background: #28a745; color: #fff; text-decoration: none; }
        .btn:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nature Spotter - Upload</h1>
        <form action="uploadsql.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label><br>
            <input type="text" name="title" id="title" required><br><br>
            
            <label for="location">Location:</label><br>
            <input type="text" name="location" id="location" required><br><br>
            
            <label for="description">Description:</label><br>
            <textarea name="description" id="description" rows="5" required></textarea><br><br>
            
            <label for="photo">Upload Photo:</label><br>
            <input type="file" name="photo" id="photo" accept="image/*" required><br><br>
            
            <input type="submit" value="Submit">
        </form>

        <p><a href="maps.html" class="btn">Go to Home Page</a></p>
        <p><a href="getPosts.php" class="btn">Go to getPosts page</a></p>
    </div>
</body>
</html>

<?php
$user = 'root';
$pass = '';
$dbName = 'naturespotter';
$db = new mysqli('localhost', $user, $pass, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $location = $_POST['location'] ?? '';
    $description = $_POST['description'] ?? '';

    // Debug: var_dump($_FILES['photo']);

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $file_tmp_path = $_FILES['photo']['tmp_name'];
        
        // Attempt to read file contents
        $photoData = file_get_contents($file_tmp_path);
        
        if ($photoData === false) {
            die("Error reading the file. Check file permissions.");
        }

        // Prepare statement
        $stmt = $db->prepare("INSERT INTO birdfinds (title, location, description, photo) VALUES (?, ?, ?, ?)");

        // Use 'b' for blob parameter
        $stmt->bind_param("sssb", $title, $location, $description, $nullPlaceholder);
        $nullPlaceholder = null; 

        // Send the actual binary data
        $stmt->send_long_data(3, $photoData);

        if ($stmt->execute()) {
            echo "Upload successful!";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }
        $stmt->close();

    } else {
        // If there's an upload error or no file
        echo "No valid photo uploaded or an error occurred: " . $_FILES['photo']['error'];
    }
}

$db->close();
?>
