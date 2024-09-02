<?php
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

$cartItems = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];

// Create a TCPDF object
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Your Organization');
$pdf->SetTitle('Invoice');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('times', '', 9);

// upload the image ktclogo.png to the same folder as the php/form file!
$pdf->Image('ktclogo.png', 10, 10, 145, 35, 'PNG');

// Add content to the PDF
$content = "
    <br><br><br><br><br><br><br><br><br><br><h1>Invoice</h1>
    <b>KidzTechCentre</b><br>www.kidztechcentre.com<br>kidztechcentrecyberjaya@gmail.com<br><br>
    <b>Student Name:</b> $studentname<br>
    <b>Email:</b> $emailstudent<br>
    <b>Parent Name:</b> $parentname<br>
    <b>Address:</b> $address<br>
    <b>School Name:</b> $schoolname<br>
    <b>Birthdate:</b> $birthdate<br><br><br>
";

if (!empty($cartItems)) {
    $content .= "<h3><b>Invoice Details:</b></h3><ul>";

    // Initialize total price and total point
    $totalPrice = 0;
    $totalPoints = 0;

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
     <th><b>Type</b></th>
     <th><b>Program Name</b></th>
     <th><b>Quantity</b></th>
     <th><b>Price per item (RM)</b></th>
     <th><b>Point per item</b></th>  
     <th><b>Booking Time</b></th> 
     <th><b>Booking Date</b></th> 
     <th><b>Subtotal Price (RM)</b></th> 
     <th><b>Subtotal Points</b></th> 
    </tr><br>";

    foreach ($cartItems as $item) {
        $type = $item['type'];
        $name = $item['program'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $point = $item['points'];
        $bookingTime = $item['booking_time'];
        $bookingDate = $item['booking_date'];

        $subtotal = $quantity * $price;
        $totalPrice += $subtotal;
        $totalPoints += $quantity * $point;

        $content .= "
            <tr>
            <td>$type</td>
            <td>$name</td>
            <td>$quantity</td>
            <td>$price</td>
            <td>$point</td>
            <td>$bookingTime</td>
            <td>$bookingDate</td>
            <td>$subtotal</td>
            <td>$subtotal</td>
            </tr><br><br>
        ";
    }
    
    $content .= "</table>";

    // Display the total price and total point
    $content .= "<br><br><br></ul><p><b>Total Price:</b> RM $totalPrice</p><p><b>Total Points:</b> $totalPoints points to be added<br><br></p>
    <br>--------------------------------------------------------------------------------------------------------------------------------------<br>– This invoice is computer-generated and requires no signature.<br>– For any inquiries, you can contact us through kidztechcentrecyberjaya@gmail.com .";

} else {
    $content .= "<h3>No items in the cart.</h3>";
}

$pdf->writeHTML($content, true, false, true, false, '');

// Output the PDF to the browser or save it to a file
$pdf->Output('invoice.pdf', 'I'); // 'I' sends the file inline to the browser
?>
