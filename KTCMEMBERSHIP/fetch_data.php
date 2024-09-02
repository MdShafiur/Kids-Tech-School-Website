<?php
$servername = "localhost";
$username = 'id19727041_ktcmembership';
$password = "Ktcmembership123$";
$dbname = 'id19727041_ktcwebsite';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the redeem table based on email

$email = $_SESSION['email'];

$sql = "SELECT redeempoint.point
        FROM tbl_member
        JOIN redeempoint ON tbl_member.email = redeempoint.email
        WHERE tbl_member.email = '$email'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // fetched data
    while ($row = $result->fetch_assoc()) {
        // Access the data
        $point = $row["point"];

        echo "<div class='dataPoint'>" . 
             "<p class='pointText'>Current Points: $point</p>" .
             "</div>";
    }
} else {
    echo "No results found.";
}

$conn->close();
?>
