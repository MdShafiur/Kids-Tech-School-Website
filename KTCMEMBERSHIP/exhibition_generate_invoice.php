<?php
session_start();

if (!isset($_SESSION["rec_id"])) {
    // Redirect to login page if the user is not logged in
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

// Get exhibition details from the URL
$exhibitionDetails = isset($_GET['exhibitionDetails']) ? json_decode(urldecode($_GET['exhibitionDetails']), true) : [];

// Create a TCPDF object
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Your Organization');
$pdf->SetAuthor($studentname);
$pdf->SetTitle('Invoice');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('times', '', 12);

// upload the image ktclogo.png to the same folder as the php/form file!
$pdf->Image('ktclogo.png',10,10,145,35,'PNG');

// Add content to the PDF
$content = "
    <br><br><br><br><br><br><h1>Invoice</h1>
    <b>KidzTechCentre</b><br>www.kidztechcentre.com<br>kidztechcentrecyberjaya@gmail.com<br><br>
    <b>Student Name:</b> $studentname<br>
    <b>Email:</b> $emailstudent<br>
    <b>Parent Name:</b> $parentname<br>
    <b>Address:</b> $address<br>
    <b>School Name:</b> $schoolname<br>
    <b>Birthdate:</b> $birthdate<br>
";

if (!empty($exhibitionDetails)) {
    $content .= "<p><b>Exhibition Details:</b></p><ul>";

    // Initialize total price and total point
    $totalPrice = 0;
    $totalPoint = 0;

    foreach ($exhibitionDetails as $detail) {
        $quantity = $detail['quantity'];
        $price = $detail['price'];
        $point = $detail['point'];

        // Calculate the subtotal for each exhibition
        $subtotalPrice = $quantity * $price;
        $subtotalPoint = $quantity * $point;

        // Add the subtotal to the total
        $totalPrice += $subtotalPrice;
        $totalPoint += $subtotalPoint;

        $content .= "<p><b>Country:</b> {$detail['countryName']}</p>
         <p><b>Quantity:</b> $quantity</p> 
         <p><b>Booking Time:</b> {$detail['bookingTime']}</p>
         <p><b>Booking Date:</b> {$detail['bookingDate']}</p>
         <p><b>Price: RM</b> $subtotalPrice</p>
         <p><b>Point:</b> $subtotalPoint<br><br></p>";
    }

    // Display the total price and total point
    $content .= "<br><br><br></ul><p><b>Total Price:</b> RM $totalPrice</p><p><b>Total Points:</b> $totalPoint points added</p>
    <br>--------------------------------------------------------------------------------------------------------------------------------------<br>– This invoice is computer-generated and requires no signature.<br>– For any inquiries, you can contact us through kidztechcentrecyberjaya@gmail.com .";

} else {
    $content .= "<p>No exhibition details found.</p>";
}

$pdf->writeHTML($content, true, false, true, false, '');

// Output the PDF to the browser or save it to a file
$pdf->Output('invoice.pdf', 'I'); // 'I' sends the file inline to the browser
?>



