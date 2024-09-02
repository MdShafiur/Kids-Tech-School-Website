<?php
if (isset($_GET["file"])) {
    $targetFile = "uploads/" . basename($_GET["file"]); // Path of the uploaded file

    // Check if the file exists
    if (file_exists($targetFile)) {
        // Display the file if it's an image
        if (is_image($targetFile)) {
            echo "<img src='" . $targetFile . "' alt='Uploaded Image'>";
        } else {
            // Otherwise, send the file for download
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename='" . basename($targetFile) . "'");
            readfile($targetFile);
            exit();
        }
    } else {
        echo "File not found.";
    }
}

// Helper function to check if a file is an image
function is_image($file) {
    $imageFormats = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return in_array($fileExtension, $imageFormats);
}
?>
