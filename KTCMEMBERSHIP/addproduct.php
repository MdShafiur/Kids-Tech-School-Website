<?php
session_start();
if (isset($_SESSION["adminemail"])) {
    $email = $_SESSION["adminemail"];
} else {
    session_unset();
    session_write_close();
    $url = "./validateadmin.php";
    header("Location: $url");
}

require 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["product_ID"];
    $productName = $_POST["product_name"];
    $price = $_POST["price"];
    $point = $_POST["point"];

    // Check if a file was uploaded
    if (isset($_FILES["file"])) {
        $file = $_FILES["file"];

        // Extract file information
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        // Generate a unique name for the file
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('', true) . '.' . $fileExtension;

        // Define the target directory and file path
        $targetDirectory = "uploads/"; // Change this to your desired directory
        $targetFilePath = $targetDirectory . $newFileName;

        // Check if the file was uploaded successfully
        if ($fileError === 0) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                // Prepare the SQL statement
                $sql = "INSERT INTO product (product_ID, product_name, price, point, file_path) VALUES (:product_ID, :product_name, :price, :point, :file_path)";
                $stmt = $conn->prepare($sql);

                // Bind the parameters
                $stmt->bindParam(':product_ID', $productId);
                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':point', $point);
                $stmt->bindParam(':file_path', $targetFilePath);

                // Execute the statement
                if ($stmt->execute()) {
                    echo "New product added successfully.";
                } else {
                    echo "Error adding new product: " . $stmt->errorInfo()[2];
                }
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Error uploading the file: " . $fileError;
        }
    }
    header("Location: adminproduct.php");
    exit;
}

$conn = null;
?>


