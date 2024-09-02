<?php
session_start();
if (isset($_SESSION["adminemail"])) {
    $email = $_SESSION["adminemail"];
} else {
    session_unset();
    session_write_close();
    $url = "./validateadmin.php";
    header("Location: $url");
    exit;
}

ob_start();

require 'db_conn.php';

// Assuming you have established a database connection
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the updated data
    $exhibitionData = $_POST["exhibition_data"];

    // Loop through the exhibition data and update each exhibition's information
    foreach ($exhibitionData as $exhibitionId => $data) {
        // Escape the values to prevent SQL injection
        $exhibitionId = $conn->real_escape_string($exhibitionId);
        $countryName = $conn->real_escape_string($data["country_name"]);
        $exhibitionPrice = $conn->real_escape_string($data["exhibition_price"]);
        $exhibitionPoint = $conn->real_escape_string($data["exhibition_point"]);

        // Updating
        $sql = "UPDATE exhibition SET country_name = '$countryName', price = '$exhibitionPrice', point = '$exhibitionPoint' WHERE id = '$exhibitionId'";

        if ($conn->query($sql) !== true) {
            echo "Error updating information for exhibition with ID $exhibitionId: " . $conn->error;
        }
        if (isset($_FILES["file_" . $exhibitionId])) {
            $targetDir = "uploads/"; // Directory where the file will be uploaded
            $targetFile = $targetDir . basename($_FILES["file_" . $exhibitionId]["name"]); // Path of the uploaded file
    
            if (move_uploaded_file($_FILES["file_" . $exhibitionId]["tmp_name"], $targetFile)) {
                echo "File uploaded successfully.";
    
                // Update the file path in the database
                $sql = "UPDATE exhibition SET file_path = '$targetFile' WHERE id = '$exhibitionId'";
    
                if ($conn->query($sql) === true) {
                    echo "File path updated successfully for product with ID $exhibitionId.";
                } else {
                    echo "Error updating file path for product with ID $exhibitionId: " . $conn->error;
                }
            } else {
                echo "Error uploading the file for product with ID $exhibitionId.";
            }
        }
    }

    header("Location: adminexhibition.php");
    ob_end_flush();
    exit;
}

$conn->close();
?>

