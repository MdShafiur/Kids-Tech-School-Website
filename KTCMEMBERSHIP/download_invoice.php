<?php
if (isset($_GET["invoice"])) {
    $invoiceFileName = $_GET["invoice"];

    // Set headers for file download
    header("Content-Type: text/plain");
    header("Content-Disposition: attachment; filename=$invoiceFileName");

    // Read and output the invoice file content
    readfile($invoiceFileName);
    exit();
} else {
    echo "Invalid request.";
}
?>
