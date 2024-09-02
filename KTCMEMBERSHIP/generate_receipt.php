<?php
ob_start();
session_start();

if (!isset($_SESSION["rec_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: ./index.php");
    exit();
}

require 'tcpdf/tcpdf.php';
require 'db_conn.php';

// Get user information from the session
$recID = $_SESSION["rec_id"];
$studentname = $_SESSION["studentname"];
$emailstudent = $_SESSION["emailstudent"];
$parentname = $_SESSION["parentname"];
$address = $_SESSION["address"];
$schoolname = $_SESSION["schoolname"];
$birthdate = $_SESSION["birthdate"];


if (isset($_GET['row_index'])) {
    $rowIndex = $_GET['row_index'];

    // Retrieve details for the specific row
    $sql = "SELECT * FROM purchases WHERE rec_id = :rec_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':rec_id', $_SESSION['rec_id']);
    $stmt->execute();

    // Fetch all rows
    $purchaseDetailsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the array is not empty and the row index is within bounds
    if (!empty($purchaseDetailsArray) && isset($purchaseDetailsArray[$rowIndex])) {
        $purchaseDetails = $purchaseDetailsArray[$rowIndex];

        // Extract data from the purchaseDetails array
        $type = $purchaseDetails["type"];
        $program = $purchaseDetails["program"];
        $quantity = $purchaseDetails["quantity"];
        $totalPrice = $purchaseDetails["total_price"];
        $totalPoints = $purchaseDetails["total_points"];
        $bookingTime = $purchaseDetails["booking_time"];
        $bookingDate = $purchaseDetails["booking_date"];
        $purchaseDate = $purchaseDetails["purchase_date"];
        $paymentMethod = $purchaseDetails["payment_method"];
        $paymentStatus = $purchaseDetails["payment_status"];

        // Create a TCPDF object
        $pdf = new TCPDF();

        // Set document information
        $pdf->SetCreator('Your Organization');
        $pdf->SetTitle('Payment Approval Receipt');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('times', '', 9);

        // Upload the image ktclogo.png to the same folder as the php/form file!
        $pdf->Image('ktclogo.png', 10, 10, 145, 35, 'PNG');





// Add content to the PDF
$content = "
    <br><br><br><h1>Receipt</h1>
    <b>KidzTechCentre</b><br>www.kidztechcentre.com<br>kidztechcentrecyberjaya@gmail.com<br><br><br><br>
    <b>Student Name:</b> $studentname<br>
    <b>Email:</b> $emailstudent<br>
    <b>Parent Name:</b> $parentname<br>
    <b>Address:</b> $address<br>
    <b>School Name:</b> $schoolname<br>
    <b>Birthdate:</b> $birthdate<br><br><br><br><br>
";

        // Add a table
        $content .= "<style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 0.5px solid #ddd;
                padding: 8px;
                text-align: center;
            }
        </style>";

        $content .= "<table>
            <tr>
                <th>Type</th>
                <th>Program/Product</th>
                <th>Quantity</th> 
                <th>Price (RM)</th>
                <th>Points</th>                
                <th>Booking Time</th>
                <th>Booking Date</th>
                <th>Order Date/Time</th>	
                <th>Payment Method</th>	
                <th>Payment Status</th>	
            </tr><br>";

        $content .= "
            <tr>
                <td>{$type}</td>
                <td>{$program}</td>
                <td>{$quantity}</td>
                <td>RM {$totalPrice}</td>
                <td>{$totalPoints} points gained</td>
                <td>{$bookingTime}</td>
                <td>{$bookingDate}</td>
                <td>{$purchaseDate}</td>
                <td>{$paymentMethod}</td>
                <td>{$paymentStatus}</td>
            </tr>
            <br><br>
        ";

        $content .= "</table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
        
        // Set the position to add the image after the table
        $pdf->SetXY(100, $pdf->GetY());

        // Add the image after the table
        $pdf->Image('PaymentApproved.png', $pdf->GetX(), $pdf->GetY() + 40, 80, 0, 'PNG');
        $pdf->SetXY(10, $pdf->GetY() + 40); // Adjust Y position as needed


        $content .= "<br>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>– This receipt is computer-generated and requires no signature.<br>– For any inquiries, you can contact us through kidztechcentrecyberjaya@gmail.com .";

        // Suppress warnings to avoid TCPDF precision warning
        @$pdf->writeHTML($content, true, false, true, false, '');

        // Suppress warnings to avoid TCPDF precision warning
        @$pdf->Close();
        @$pdf->Output();

        ob_end_flush();
        exit;
    } else {
        echo "Invalid row index or purchase details not found.";
    }
} else {
    echo "Row index not set.";
}
?>
