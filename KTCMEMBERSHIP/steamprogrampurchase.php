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

// Establish database connection
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve program quantity for each program type
$result = $conn->query("SELECT * FROM updatesteamprogrampage");

// Check if the query was executed successfully
if (!$result) {
    echo "Error executing query: " . $conn->error;
    // Close the database connection
    $conn->close();
    exit(); // Stop further execution
}

if ($result->num_rows > 0) {
    $programType = 1; // Set program type

    $stmt = $conn->prepare("SELECT studentname FROM tbl_member WHERE rec_id = ?");
    $stmt->bind_param("s", $recID);
    $stmt->execute();
    $stmt->bind_result($studentName);
    $stmt->fetch();
    $stmt->close();

    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO schoolprogrampurchase (rec_id, studentname, program_name, quantity, price, point, total_price, total_points, image_filename, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    while ($row = $result->fetch_assoc()) {
        $programName = $row['program_name'];
        $price = $row['price'];
        $points = $row['point'];

        // Retrieve program quantity from the form submission
        $quantityKey = 'quantity-' . $programType;
        $programQuantity = isset($_POST[$quantityKey]) ? $_POST[$quantityKey] : 0;

        // Calculate the total price and points
        $totalPrice = $price * $programQuantity;
        $totalPoints = $points * $programQuantity;

        // Check if the program quantity is greater than 0
        if ($programQuantity > 0) {
            // Check if the payment method is 'bank'
            if (isset($_POST['payment_method']) && $_POST['payment_method'] === 'bank') {
                $imageFileName = ""; // Default value for 'bank' payment

                // Handle the uploaded file for 'bank' payment
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    // Specify the target directory to save the uploaded file
                    $targetDirectory = "uploads/";
                    // Generate a unique filename for the uploaded file
                    $imageFileName = uniqid() . '_' . $_FILES['file']['name'];
                    // Specify the target path for the uploaded file
                    $targetPath = $targetDirectory . $imageFileName;

                    // Move the uploaded file to the target directory
                    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                        echo "Error moving the uploaded file.";
                        exit();
                    }
                }

                // Set 'image_filename' for 'bank' payment
                $paymentMethod = $_POST['payment_method'];
                $stmt->bind_param("sssiidddss", $recID, $studentName, $programName, $programQuantity, $price, $points, $totalPrice, $totalPoints, $imageFileName, $paymentMethod);
            } else {
                // Payment method is 'cash'
                $imageFileName = ""; // Empty image filename for cash payment
                $paymentMethod = "cash"; // Set a default value for 'cash' payment
                $stmt->bind_param("sssiidddss", $recID, $studentName, $programName, $programQuantity, $price, $points, $totalPrice, $totalPoints, $imageFileName, $paymentMethod);
            }

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Data inserted successfully.";
            } else {
                echo "Error inserting data: " . $stmt->error;
            }
        }

        $programType++;
    }
} else {
    echo "No programs found.";
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();

echo "<script>alert('Data inserted successfully.');</script>";

// Redirect to 'steamprogram.php'
echo "<script>window.location.href = 'steamprogram.php';</script>";
exit();
?>

