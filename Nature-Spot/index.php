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
            text-align: center;
        }
        header {
            background: #066402;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
        }
        .cta-buttons button {
            margin: 5px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            background: white;
            color:#066402;
            font-weight: bold;
            border-radius: 5px;
        }
        .cta-buttons button:hover {
            background: #066402;
            color: white;
        }
        .content {
            padding: 50px;
        }
        gmp-map {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <header>
        <h1>My Website</h1>
        <div class="cta-buttons">
            
            <a href="signup.html"class ="btn">Sign Up</a>
            <a href="learnMore.html"class ="btn">Learn More</a>
           
        </div>
    </header>
    
    <div class="content">
        <h2>Welcome to Our Website</h2>
        <p>Discover the best places in Manchester and explore exciting locations.</p>
    </div>
    
    <?php include "resources/map.php"; ?>
    
    </body>
</html>
