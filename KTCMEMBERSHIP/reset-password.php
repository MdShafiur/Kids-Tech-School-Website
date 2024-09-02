<?php
// reset-password.php

$token = $_GET['token'];

$token_hash = hash("sha256", $token);

$pdo = require __DIR__ . "/db_conn.php";

// Verify token against the database and check if it's not expired
$sql = "SELECT * FROM tbl_member WHERE reset_token_hash = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token_hash]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result === false) {
    die("token not found");
}

if (strtotime($result["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

// Display the form to reset password
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('assets/img/DSC04731.jpg'); /* Add your image URL here */
            background-size: cover;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="post" action="process-reset.php">
        <h1>Reset Password</h1>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" required>
        <label for="password_confirmation">Repeat Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>

