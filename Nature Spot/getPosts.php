<?php
$user = 'root';
$pass = '';
$dbName = 'naturespotter';
$db = new mysqli('localhost', $user, $pass, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$search = $_GET['search'] ?? '';
$query = "SELECT title, location, description, photo FROM birdfinds";
if (!empty($search)) {
    $query .= " WHERE title LIKE ? OR location LIKE ?";
}

$stmt = $db->prepare($query);
if (!empty($search)) {
    $searchParam = "%$search%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nature Spotter Posts</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { width: 80%; margin: 20px auto; }
        .posts-wrapper { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .post {
            width: 30%;
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left;
        }
        img { width: 100%; height: auto; border-radius: 5px; }
        .search-bar { margin-bottom: 20px; }
        .btn { display: inline-block; margin: 10px; padding: 10px 15px; background: #066402; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #044d01; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nature Spotter - Posts</h1>
        <form method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Search by title or location" value="<?= htmlspecialchars($search) ?>">
            <input type="submit" value="Search">
        </form>
        <p><a href="uploadsql.php" class="btn">Go to upload page</a></p>
        <p><a href="maps.html" class="btn">Go to homepage</a></p>

        <div class="posts-wrapper">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <h2><?= htmlspecialchars($row['title']) ?></h2>
                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                    <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    <?php if (!empty($row['photo'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($row['photo']) ?>" alt="Uploaded Photo">
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$db->close();
?>