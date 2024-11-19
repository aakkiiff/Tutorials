<?php

date_default_timezone_set("Asia/Dhaka"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PHP Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2rem;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .container h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }
        .info {
            list-style-type: none;
            padding: 0;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .info li {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }
        .info li:hover {
            background-color: #e0e0e0;
        }
        .time {
            background-color: #2196F3;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.5rem;
            margin: 30px 0;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            font-size: 1rem;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to PHP Demo</h1>
</header>

<div class="container">
    <h2>Current Server Info</h2>

    <div class="time">
        <p>Current Server Time: <strong><?php echo date("Y-m-d H:i:s"); ?></strong></p>
    </div>

    <p>Here's some information about the server:</p>
    <ul class="info">
        <li><strong>PHP Version:</strong> <?php echo phpversion(); ?></li>
        <li><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
        <li><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
        <li><strong>Server IP Address:</strong> <?php echo $_SERVER['SERVER_ADDR']; ?></li>
        <li><strong>Request Method:</strong> <?php echo $_SERVER['REQUEST_METHOD']; ?></li>
    </ul>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> PHP Demo. All rights reserved.</p>
</footer>

<script>
    setInterval(function() {
        const timeElement = document.querySelector('.time p');
        const currentTime = new Date().toLocaleString('en-US', { hour12: true });
        timeElement.innerHTML = 'Current Server Time: <strong>' + currentTime + '</strong>';
    }, 1000);
</script>

</body>
</html>
