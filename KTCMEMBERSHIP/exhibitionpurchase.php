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

ob_start();

// Retrieve student name from tbl_member
$studentName = '';
$stmt = $conn->prepare("SELECT studentname FROM tbl_member WHERE rec_id = ?");
$stmt->bind_param("s", $recID);
$stmt->execute();
$stmt->bind_result($studentName);
$stmt->fetch();
$stmt->close();

// Retrieve form data
$exhibitionIds = $_POST['exhibition_id'];
$countrynames = $_POST['country_name'];
$quantities = $_POST['quantity'];
$bookingTimes = $_POST['booking_time'];
$bookingDates = $_POST['booking_date'];
$prices = $_POST['price'];
$points = $_POST['point'];
$totalPrice = 0;
$totalPoints = 0;

// Insert data into database
foreach ($exhibitionIds as $key => $exhibitionId) {
    // Check if the submit button for this row was clicked
    if (isset($_POST['submitBtn' . $exhibitionId])) {
        $quantity = $quantities[$key];
        $bookingTime = $bookingTimes[$key];
        $bookingDate = $bookingDates[$key];
        $countryname = $countrynames[$key];
        $price = $prices[$key];
        $point = $points[$key];
        $paymentOption = $_POST['payment_option' . $exhibitionId];

        // Calculate the row price and point
        $rowPrice = $price * $quantity;
        $rowPoint = $point * $quantity;
        $totalPrice += $rowPrice;
        $totalPoints += $rowPoint;

        // Upload file for the row
        $uploadFilePath = '';
        if ($_FILES['upload_file']['error'][$key] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['upload_file']['tmp_name'][$key];
            $fileName = $_FILES['upload_file']['name'][$key];
            $fileSize = $_FILES['upload_file']['size'][$key];
            $fileType = $_FILES['upload_file']['type'][$key];

            // Set the directory to save the uploaded files
            $uploadDirectory = 'uploads/';

            // Generate a unique name for the file to avoid conflicts
            $uniqueFileName = uniqid() . '_' . $fileName;

            // Move the uploaded file to the desired location
            $uploadFilePath = $uploadDirectory . $uniqueFileName;
            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                // File uploaded successfully
            } else {
                echo "Error uploading file.";
            }
        }

        // Store the calculated values back into the arrays
        $prices[$key] = $rowPrice;
        $points[$key] = $rowPoint;

        // SQL statement
        $sql = "INSERT INTO exhibition_purchase (exhibition_id, rec_id, studentname, country_name, quantity, price, point, booking_time, booking_date, image_filename, payment_method, total_price, total_points) 
                VALUES ('$exhibitionId', '$recID', '$studentName', '$countryname', '$quantity', '$rowPrice', '$rowPoint', '$bookingTime', '$bookingDate', '$uploadFilePath', '$paymentOption', '$totalPrice', '$totalPoints')";

        if ($conn->query($sql) === TRUE) {
            // Data inserted successfully
            $conn->close();
            echo "<script>alert('Data inserted successfully.');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        break; // Exit the loop after processing the clicked row
    }
}
ob_end_flush();
?>

<script>
    alert('Data inserted successfully.');
    window.location.href = 'exhibition.php';
</script>

