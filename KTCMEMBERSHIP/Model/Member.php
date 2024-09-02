<?php
namespace ktc;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload.php file
require '../KTCMEMBERSHIP/vendor/phpmailer/phpmailer/src/Exception.php';
require '../KTCMEMBERSHIP/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../KTCMEMBERSHIP/vendor/phpmailer/phpmailer/src/SMTP.php';

class Member
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    /**
     * to check if the username already exists
     *
     * @param string $username
     * @return boolean
     */
    public function isUsernameExists($username)
    {
        $query = 'SELECT * FROM tbl_member where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to check if the email already exists
     *
     * @param string $email
     * @return boolean
     */
    public function isEmailExists($email)
    {
        $query = 'SELECT * FROM tbl_member where email = ?';
        $paramType = 's';
        $paramValue = array(
            $email
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function isEmailStudentExists($EmailStudent)
    {
        $query = 'SELECT * FROM tbl_member where emailstudent = ?';
        $paramType = 's';
        $paramValue = array(
            $EmailStudent
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to signup / register a user
     *
     * @return string[] registration status message
     */
    public function registerMember()
    {
        $isUsernameExists = $this->isUsernameExists($_POST["username"]);
        $isEmailExists = $this->isEmailExists($_POST["email"]);
        $isEmailStudentExists = $this->isEmailStudentExists($_POST['emailstudent']);
        $birthdate = $_POST['birthdate'];

        if (empty($birthdate)) {
            $response = array(
                "status" => "error",
                "message" => "Please provide a valid birth date."
            );
            return $response;
        }

        if ($isUsernameExists) {
            $response = array(
                "status" => "error",
                "message" => "Username already exists."
            );
        } else if ($isEmailExists) {
            $response = array(
                "status" => "error",
                "message" => "Email already exists."
            );
        }
         else {
            $query = 'INSERT INTO tbl_member (username, password, email, emailstudent, parentname, studentname, address, schoolname, birthdate, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $paramType = 'ssssssssss';
            $paramValue = array(
                $_POST["username"],
                $_POST["signup-password"],
                $_POST["email"],
                $_POST['emailstudent'],
                $_POST['parentname'],
                $_POST['studentname'],
                $_POST['address'],
                $_POST['schoolname'],
                $birthdate, // Insert the birthdate variable here
                $_POST['telephone']
            );
            $memberId = $this->ds->insert($query, $paramType, $paramValue);
            if (!empty($memberId)) {
                // Fetch the rec_id and display as a popup
                $recIdQuery = "SELECT rec_id FROM tbl_member WHERE id = ?";
                $recIdParamType = "i";
                $recIdParamValue = array($memberId);
                $recIdResult = $this->ds->select($recIdQuery, $recIdParamType, $recIdParamValue);

                if (!empty($recIdResult)) {
                    $recId = $recIdResult[0]['rec_id'];
                    // Display a popup with the auto-generated ID
                    echo "<script>alert('Registration Successful.\\nYour ID: " . $recId . "\\nPlease login to continue.');</script>";
                }
                $this->sendThankYouEmail($_POST["email"]);
                $response = array(
                    "status" => "success",
                    "message" => "You have registered successfully.",
                    "memberId" => $memberId
                );
            }
        }

        // Display the error message in the registration popup
        if ($response["status"] === "error") {
            echo "<script>displayErrorMessage('" . $response["message"] . "');</script>";
        }

        return $response;
    }

/**
 * Sends a "thank you for joining" email to the specified email address.
 *
 * @param string $email The email address of the user
 * @return void
 */
private function sendThankYouEmail($email)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Specify your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kidztechcentrecyberjaya@gmail.com';  // SMTP username
        $mail->Password   = 'fwcyjahjiokssbdw';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587;  // TCP port to connect to

        $mail->setFrom('kidztechcentrecyberjaya@gmail.com', 'KidzTechCentre');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Thank You for Joining';

        // Fetch the username from the database based on the provided email
        $memberRecord = $this->getMemberByUsername($_POST["username"]);
        $username = !empty($memberRecord) ? $memberRecord[0]["username"] : '';

        // Construct the email body
        $emailBody = "
            <p>Hi $username,</p>
            <p>Thank you for registering an account with us. Your login details are given below:</p>
            <p>Email: $email</p>
            <p>If there is anything you need, our customer happiness team is available to you over email at kidztechcentrecyberjaya@gmail.com</p>
            <p>See you soon at <a href='https://www.kidztechcentre.com/'>https://www.kidztechcentre.com/</a></p>
            <p>Sportingly,<br>Team KidzTechCentre, DreamEdge<br><a href='https://www.kidztechcentre.com/'>https://www.kidztechcentre.com/</a></p>
        ";

        $mail->Body = $emailBody;

        $mail->send();
    } catch (Exception $e) {
        // Log any errors if needed
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

/**
 * Retrieve a member's record based on the provided username.
 *
 * @param string $username The username of the user
 * @return array
 */
private function getMemberByUsername($username)
{
    $query = 'SELECT * FROM tbl_member where username = ?';
    $paramType = 's';
    $paramValue = array($username);
    return $this->ds->select($query, $paramType, $paramValue);
}

public function getMember($recID)
{
    $query = 'SELECT * FROM tbl_member where username = ?';
    $paramType = 's';
    $paramValue = array(
        $recID
    );
    $memberRecord = $this->ds->select($query, $paramType, $paramValue);
    return $memberRecord;
}

/**
 * to login a user
 *
 * @return string
 */
public function loginMember()
{
    $memberRecord = $this->getMember($_POST["username"]);
    $loginPassword = 0;

    if (!empty($memberRecord)) {
        if (!empty($_POST["login-password"])) {
            $password = $_POST["login-password"];
        }
        $storedPassword = $memberRecord[0]["password"];

        if ($password == $storedPassword) {
            $loginPassword = 1;
        }
    } else {
        $loginPassword = 0;
    }

    if ($loginPassword == 1) {
        // login success, store member's information in the session
        session_start();
        $_SESSION["rec_id"] = $memberRecord[0]["rec_id"];
        $_SESSION["studentname"] = $memberRecord[0]["studentname"];
        $_SESSION["emailstudent"] = $memberRecord[0]["emailstudent"];
        $_SESSION["parentname"] = $memberRecord[0]["parentname"];
        $_SESSION["address"] = $memberRecord[0]["address"];
        $_SESSION["schoolname"] = $memberRecord[0]["schoolname"];
        $_SESSION["birthdate"] = $memberRecord[0]["birthdate"];

        session_write_close();
        $url = "./home.php";
        header("Location: $url");
    } else if ($loginPassword == 0) {
        $loginStatus = "Invalid username or password.";
        return $loginStatus;
    }
}

public function updateMemberInfo($email, $studentname, $emailstudent, $age, $parentname, $address, $schoolname) {
    $query = "UPDATE members SET studentname = ?, emailstudent = ?, age = ?, parentname = ?, address = ?, schoolname = ? WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ssissss", $studentname, $emailstudent, $age, $parentname, $address, $schoolname, $email);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
}
