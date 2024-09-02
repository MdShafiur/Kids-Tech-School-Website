<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
?>

<?php
// Fetch data from the database
$servername = "localhost";
$username = "id19727041_ktcmembership";
$password = "Ktcmembership123$";
$dbname = "id19727041_ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment method
    $paymentMethod = $_POST['payment_method'];

    // File upload handling
    $targetDir = ""; // Provide the target directory where you want to save the uploaded files
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    echo "Target file: " . $targetFile . "<br>";

    $studentName = '';
    $sql = "SELECT studentname FROM tbl_member WHERE rec_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $recID);
    $stmt->execute();
    $stmt->bind_result($studentName);
    $stmt->fetch();
    $stmt->close();

    if ($paymentMethod == "cash") {
        // Prepare and execute SQL statement to insert data without file path
        $stmt = $conn->prepare("INSERT INTO classpurchase (rec_id, studentname, class_name, quantity, price, point, total_price, total_points, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssidddds", $recID, $studentName, $className, $quantity, $price, $point, $totalPrice, $totalPoints, $paymentMethod);
    } else if ($paymentMethod == "bank") {
        // Check if file is uploaded
        if (!empty($_FILES["file"]["name"])) {
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                echo "File uploaded successfully.<br>";

                // Prepare and execute SQL statement to insert data with file path
                $stmt = $conn->prepare("INSERT INTO classpurchase (rec_id, studentname, class_name, quantity, price, point, total_price, total_points, image_filename, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssidddsss", $recID, $studentName, $className, $quantity, $price, $point, $totalPrice, $totalPoints, $targetFile, $paymentMethod);
            } else {
                $_SESSION['file_upload_error'] = "Please upload a file for bank payment method.";
                header("Location: class.php");
                exit();
            }
        } else {
            $_SESSION['file_upload_error'] = "Please upload a file for bank payment method.";
            header("Location: class.php");
            exit();
        }
    }

    // Process the form data
    foreach ($_POST['quantity'] as $className => $quantity) {
        // Retrieve form data
        $className = $_POST['class_name'][$className];
        $startPrice = $_POST['price'][$className];
        $startPoint = $_POST['point'][$className];

        // Calculate total price and point based on quantity
        $price = $startPrice * $quantity;
        $point = $startPoint * $quantity;
        $totalPrice = $price; // Assuming no additional calculation for total_price
        $totalPoints = $point; // Assuming no additional calculation for total_points

        // Check if quantity is more than 0
        if ($quantity > 0) {
            // Execute the prepared statement for each record
            $stmt->execute();
        }
    }

    // Close the prepared statement
    $stmt->close();

    echo "<script>alert('Data inserted successfully.');</script>";

    // Redirect to 'exhibition.php'
    echo "<script>window.location.href = 'class.php';</script>";
    exit();}
?>