<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $targetDir = "uploads/"; // Directory where the file will be uploaded
    $targetFile = $targetDir . basename($_FILES["file"]["name"]); // Path of the uploaded file

    // Try to move the uploaded file to the specified directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "File uploaded successfully.";

        // Store the file path in a database or other persistent storage
        $filePath = $targetFile;
        // Here, you can insert the $filePath into your database or perform any necessary actions to store it for later use.

        // Redirect to the other page and pass the filename as a parameter
        header("Location: product.php?file=" . urlencode($_FILES["file"]["name"]));
        exit();
    } else {
        echo "Error uploading the file.";
    }
}
?>

