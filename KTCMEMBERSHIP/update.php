<?php
// Start the session
session_start();

// Get the form data
$recID = $_POST['rec_id'];
$studentname = $_POST['studentname'];
$emailstudent = $_POST['emailstudent'];
$birthdate = $_POST['birthdate'];
$parentname = $_POST['parentname'];
$address = $_POST['address'];
$schoolname = $_POST['schoolname'];
$telephone = $_POST['telephone'];
$userPassword = $_POST['password'];

// Connect to the database
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "UPDATE tbl_member SET ";

if (!empty($studentname)) {
  $sql .= "studentname = '$studentname', ";
}

if (!empty($emailstudent)) {
  $sql .= "emailstudent = '$emailstudent', ";
}

if (!empty($birthdate)) {
  $sql .= "birthdate = '$birthdate', ";
}

if (!empty($parentname)) {
  $sql .= "parentname = '$parentname', ";
}

if (!empty($address)) {
  $sql .= "address = '$address', ";
}

if (!empty($schoolname)) {
  $sql .= "schoolname = '$schoolname', ";
}

if (!empty($telephone)) {
  $sql .= "telephone = '$telephone', ";
}

if (!empty($userPassword)) {
  $sql .= "password = '$userPassword', ";
}

// Remove the last comma and space
$sql = rtrim($sql, ', ');

// Add the WHERE clause to update the correct record
$sql .= " WHERE rec_id = '$recID'";

// Execute the SQL statement
if ($conn->query($sql) === TRUE) {

    // Set the session variables with the updated values
    $_SESSION['rec_id'] = $recID;
    $_SESSION['studentname'] = $studentname;
    $_SESSION['emailstudent'] = $emailstudent;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['parentname'] = $parentname;
    $_SESSION['address'] = $address;
    $_SESSION['schoolname'] = $schoolname;
    $_SESSION['telephone'] = $telephone;
    $_SESSION['password'] = $userPassword;
    
    // Redirect to personal info page
    header("Location: personalinfo.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
