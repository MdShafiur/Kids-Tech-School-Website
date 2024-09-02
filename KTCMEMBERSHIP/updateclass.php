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
    $classData = $_POST["class_data"];

    // Loop through the product data and update each product's information
    // Loop through the product data and update each product's information
foreach ($classData as $classId => $data) {
    // Escape the values to prevent SQL injection
    $classId = $conn->real_escape_string($classId);
    $className = $conn->real_escape_string($data["class_name"]);
    $classPrice = $conn->real_escape_string($data["class_price"]);
    $classPoint = $conn->real_escape_string($data["class_point"]);

    // Updating
    $sql = "UPDATE class SET class_name = '$className', price = '$classPrice', point = '$classPoint' WHERE id = '$classId'";

    if ($conn->query($sql) !== true) {
        echo "Error updating information for product with ID $classId: " . $conn->error;
    }

    // Handle the file upload for the current product
    if (isset($_FILES["file_" . $classId])) {
        $targetDir = "uploads/"; // Directory where the file will be uploaded
        $targetFile = $targetDir . basename($_FILES["file_" . $classId]["name"]); // Path of the uploaded file

        if (move_uploaded_file($_FILES["file_" . $classId]["tmp_name"], $targetFile)) {
            echo "File uploaded successfully.";

            // Update the file path in the database
            $sql = "UPDATE class SET file_path = '$targetFile' WHERE id = '$classId'";

            if ($conn->query($sql) === true) {
                echo "File path updated successfully for product with ID $classId.";
            } else {
                echo "Error updating file path for product with ID $classId: " . $conn->error;
            }
        } else {
            echo "Error uploading the file for product with ID $classId.";
        }
    }
}


    header("Location: adminclass.php");
    ob_end_flush();
    exit;
}

$conn->close();
?>
