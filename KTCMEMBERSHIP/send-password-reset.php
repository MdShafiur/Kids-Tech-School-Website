<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../KTCMEMBERSHIP/vendor/phpmailer/phpmailer/src/Exception.php';
require '../KTCMEMBERSHIP/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../KTCMEMBERSHIP/vendor/phpmailer/phpmailer/src/SMTP.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-image: url("assets/img/DSC04731.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .success-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: green;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .success-message {
            color: green;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .redirect-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .redirect-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);

$pdo = require __DIR__ . "/db_conn.php";

// Check if the email exists in the database
$checkEmailSql = "SELECT * FROM tbl_member WHERE email = ?";
$checkEmailStmt = $pdo->prepare($checkEmailSql);
$checkEmailStmt->execute([$email]);

if ($checkEmailStmt->rowCount() > 0) {
    // Email found, proceed with password reset

    $updateSql = "UPDATE tbl_member
                  SET reset_token_hash = ?,
                      reset_token_expires_at = ?
                  WHERE email = ?";

    try {
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$token_hash, date("Y-m-d H:i:s", time() + 60 * 30 * 24), $email]);

        // Send email with PHPMailer
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Specify your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kidztechcentrecyberjaya@gmail.com';  // SMTP username
        $mail->Password   = 'fwcyjahjiokssbdw';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587;  // TCP port to connect to

        $mail->setFrom('kidztechcentrecyberjaya@gmail.com', 'KidzTechCentre');
        $mail->addAddress($email); // Add a recipient

        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'Password Reset';
        $mail->Body    = 'Click the following link to reset your password: <a href="http://localhost/kidztechcentre/KTCMEMBERSHIP/reset-password.php?token=' . urlencode($token) . '">Reset Password</a>';

        $mail->send();
        echo '<div class="success-box">Email sent successfully</div>';

        // Add a button to redirect to index.php
        echo '<form action="index.php">
                <button class="redirect-button" type="submit">Go to Login</button>
              </form>';
        exit();
    } catch (PDOException $e) {
        die("Error updating database: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error sending email: " . $mail->ErrorInfo);
    }
} else {
    echo 'Email not found in the database. Please check the email address and try again.';
}
?>

</body>
</html>
