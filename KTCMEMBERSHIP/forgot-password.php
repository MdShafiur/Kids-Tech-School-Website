<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="shortcut icon" href="../assets/img/logo.svg" type="image/svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/phppot-style.css">
    <link rel="stylesheet" href="assets/css/user-registration.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url("assets/img/DSC04731.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #666;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
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
    <form method="post" action="send-password-reset.php">
        <h1>Forgot Password</h1>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <button type="submit"><i class="fas fa-paper-plane"></i> Send</button>
    </form>
    <script src="vendor/jquery/jquery-3.3.1.js"></script>
</body>
</html>
