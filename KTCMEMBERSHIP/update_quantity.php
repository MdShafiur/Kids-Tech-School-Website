<?php
session_start();

if (isset($_SESSION["rec_id"])) {
    $recID = $_SESSION["rec_id"];
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
    exit;
}

$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productIds = $_POST["product_id"];
    $quantities = $_POST["quantity"];
    $paymentMethod = $_POST["payment_method"];
    

    // Retrieve student name from tbl_member using rec_id
    $stmt = $conn->prepare("SELECT studentname FROM tbl_member WHERE rec_id = ?");
    $stmt->bind_param("s", $recID);
    $stmt->execute();
    $stmt->bind_result($studentName);
    $stmt->fetch();
    $stmt->close();
    $invoiceContent = "Invoice Details:\n";
    $invoiceContent .= "Student Name: $studentName\n";
    $invoiceContent .= "Payment Method: $paymentMethod\n";

    // Handle the uploaded file if payment method is "bank"
    if ($paymentMethod == "bank") {
        $file = $_FILES["file"];
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        if ($fileError === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                foreach ($productIds as $index => $productId) {
                    $quantity = $quantities[$index];

                    // Skip the row if the quantity is 0
                    if ($quantity == 0) {
                        continue;
                    }

                    // Retrieve the corresponding product details from the database based on the product ID
                    $sql = "SELECT id, product_name, price, point FROM product WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $productName = $row["product_name"];
                        $price = $row["price"];
                        $point = $row["point"];

                        // Calculate the final price and point by multiplying with the quantity
                        $finalPrice = $price * $quantity;
                        $finalPoint = $point * $quantity;

                        // Insert the product details with the final price, point, and uploaded file path into the "productpurchase" table
                        $insertSql = "INSERT INTO productpurchase (product_id, product_name, price, point, quantity, rec_id, payment_method, image_filename, studentname, total_price, total_points) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $insertStmt = $conn->prepare($insertSql);
                        $insertStmt->bind_param("issiissssid", $productId, $productName, $price, $point, $quantity, $recID, $paymentMethod, $fileName, $studentName, $finalPrice, $finalPoint);
                        $insertStmt->execute();
                        $insertStmt->close();
                        $invoiceContent .= "Product Name: $productName\n";
            $invoiceContent .= "Quantity: $quantity\n";
            $invoiceContent .= "Price: $price\n";
            $invoiceContent .= "Total Price: $finalPrice\n";
                    }
                    
                    $stmt->close(); // Close the statement after each iteration
                }
                 $invoiceFileName = "invoice_$recID.txt";
    file_put_contents($invoiceFileName, $invoiceContent);

    // Redirect to the page where user can download the invoice
    $downloadUrl = "download_invoice.php?invoice=$invoiceFileName";
    header("Location: $downloadUrl");
    exit();
            } else {
                // Failed to move the uploaded file
                // Handle the error
                // ...
            }
        } else {
            // No file uploaded or an error occurred during upload
            // Handle the error
            // ...
        }
    } else {
        // Payment method is "cash"
        foreach ($productIds as $index => $productId) {
            $quantity = $quantities[$index];

            // Skip the row if the quantity is 0
            if ($quantity == 0) {
                continue;
            }

            // Retrieve the corresponding product details from the database based on the product ID
            $sql = "SELECT id, product_name, price, point FROM product WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $productName = $row["product_name"];
                $price = $row["price"];
                $point = $row["point"];

                // Calculate the final price and point by multiplying with the quantity
                $finalPrice = $price * $quantity;
                $finalPoint = $point * $quantity;

                // Insert the product details with the final price and point into the "productpurchase" table without the image_filename
                $insertSql = "INSERT INTO productpurchase (product_id, product_name, price, point, quantity, payment_method, rec_id, studentname, total_price, total_points) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("issiissssi", $productId, $productName, $price, $point, $quantity, $paymentMethod, $recID, $studentName, $finalPrice, $finalPoint);
                $insertStmt->execute();
                $insertStmt->close();
                $invoiceContent .= "Product Name: $productName\n";
            $invoiceContent .= "Quantity: $quantity\n";
            $invoiceContent .= "Price: $price\n";
            $invoiceContent .= "Total Price: $finalPrice\n";
            }
            
            $stmt->close(); // Close the statement after each iteration
        }
       header('Content-Description: File Transfer');
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="invoice.txt"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($invoiceContent));
    
    // Output the invoice content directly to the user's browser
    echo $invoiceContent;
        exit();
        }
}

$conn->close();
header("Location: download_invoice.php");
exit();
?>
