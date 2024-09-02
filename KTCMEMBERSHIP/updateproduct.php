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
    $productData = $_POST["product_data"];

    // Loop through the product data and update each product's information
    // Loop through the product data and update each product's information
foreach ($productData as $productId => $data) {
    // Escape the values to prevent SQL injection
    $productId = $conn->real_escape_string($productId);
    $productName = $conn->real_escape_string($data["product_name"]);
    $productPrice = $conn->real_escape_string($data["product_price"]);
    $productPoint = $conn->real_escape_string($data["product_point"]);

    // Updating
    $sql = "UPDATE product SET product_name = '$productName', price = '$productPrice', point = '$productPoint' WHERE id = '$productId'";

    if ($conn->query($sql) !== true) {
        echo "Error updating information for product with ID $productId: " . $conn->error;
    }

    // Handle the file upload for the current product
    if (isset($_FILES["file_" . $productId])) {
        $targetDir = "uploads/"; // Directory where the file will be uploaded
        $targetFile = $targetDir . basename($_FILES["file_" . $productId]["name"]); // Path of the uploaded file

        if (move_uploaded_file($_FILES["file_" . $productId]["tmp_name"], $targetFile)) {
            echo "File uploaded successfully.";

            // Update the file path in the database
            $sql = "UPDATE product SET file_path = '$targetFile' WHERE id = '$productId'";

            if ($conn->query($sql) === true) {
                echo "File path updated successfully for product with ID $productId.";
            } else {
                echo "Error updating file path for product with ID $productId: " . $conn->error;
            }
        } else {
            echo "Error uploading the file for product with ID $productId.";
        }
    }
}


    header("Location: adminproduct.php");
    ob_end_flush();
    exit;
}

$conn->close();
?>
