<?php
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["deletePoster"])) {
    // Retrieve the latest uploaded poster filename from the database
    $selectSql = "SELECT image_filename FROM programposter ORDER BY id DESC LIMIT 1";
    $result = $conn->query($selectSql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filenameToDelete = $row["image_filename"];
        
        // Delete the file from the server
        $targetDir = "";
        $targetFileToDelete = $targetDir . $filenameToDelete;
        if (file_exists($targetFileToDelete)) {
            unlink($targetFileToDelete);
        }
        
        // Delete the row from the database
        $deleteSql = "DELETE FROM programposter WHERE image_filename = '$filenameToDelete'";
        if ($conn->query($deleteSql) === true) {
            echo "Poster deleted successfully.";
        } else {
            echo "Error deleting poster: " . $conn->error;
        }
    } else {
        echo "No posters found to delete.";
    }
}

$conn->close();
?>
