<?php
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
ob_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the updated data
    $programData = $_POST["program_data"];

    // Loop through the product data and update each product's information
    foreach ($programData as $programId => $data) {
        // Escape the values to prevent SQL injection
        $programId = $conn->real_escape_string($programId);
        $programType = $conn->real_escape_string($data["program_type"]);
        $programName = $conn->real_escape_string($data["program_name"]);
        $programPrice = $conn->real_escape_string($data["program_price"]);
        $programPoint = $conn->real_escape_string($data["program_point"]);

        // Updating
        $sql = "UPDATE updatesteamprogrampage SET programtype = '$programType', program_name = '$programName', price = '$programPrice', point = '$programPoint' WHERE id = '$programId'";

        if ($conn->query($sql) !== true) {
            echo "Error updating information for program with ID $programId: " . $conn->error;
        }
    }

    header("Location: adminsteamprogram.php");
    ob_end_flush();
    exit;
}

$conn->close();
?>

