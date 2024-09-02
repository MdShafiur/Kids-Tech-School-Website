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

// Get product details from the URL
$productDetailsJSON = isset($_GET['productDetails']) ? $_GET['productDetails'] : '[]';
$productDetails = json_decode($productDetailsJSON, true);

// Check if decoding was successful
if ($productDetails === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding product details JSON.');
}

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

if (!empty($productDetails)) {
    $content .= "<p><b>Product Details:</b></p><ul>";

    // Initialize total price and total point
    $totalPrice = 0;
    $totalPoint = 0;


    
    $content .= "<table>
    <tr>
     <th><b>Product</b></th>
     <th><b>Price (RM)</b></th>
     <th><b>Quantity</b></th>
     <th><b>Subtotal Price</b></th>
     <th><b>Subtotal Points</b></th>  
    </tr>";

    foreach ($productDetails as $detail) {
        $productId = $detail['productId'];
        $quantity = $detail['quantity'];

        // Look up the product information based on the product ID
        $price = 0; // Set the default price
        $points = 0; // Set the default points

        // Convert product IDs to lowercase for case-insensitive comparison

        // Implement your logic to fetch product information based on the product ID
        // For example, you can query the database or use a switch statement

        switch ($productId) {
            case '01':
                $productName = "KidzTechCentreButtonBadge"; 
                $price = 3; 
                $points = 3; 
                break;
            case '02':
                $productName = "Bionic Worm Crawling Robot"; 
                $price = 15; 
                $points = 15; 
                break;
            case '03':
                $productName = "Geared Mobile Robot"; 
                $price = 18; 
                $points = 18; 
                break;
            case '04':
                $productName = "Cap KidzTechCentre Logo"; 
                $price = 20; 
                $points = 20; 
                break;
            case '06':
                $productName = "Remote Control Car"; 
                $price = 25; 
                $points = 25; 
                break;
            case '07':
                $productName = "Apitor SuperBot (STEM)"; 
                $price = 350; 
                $points = 350; 
                break;
        }

        // Calculate the subtotal for each product
        $subtotalPrice = $quantity * $price;
        $subtotalPoint = $quantity * $points;

        // Add the subtotal to the total
        $totalPrice += $subtotalPrice;
        $totalPoint += $subtotalPoint;

        $content .= "
     <tr>
      <td>$productName</td>
      <td> $price</td>  
      <td> $quantity</td>
      <td> $subtotalPrice</td>
      <td> $subtotalPoint</td>
     </tr> 
     ";  
    }
    $content .= "</table>";
    /// Display the total price and total point
    $content .= "<br><br><br></ul><p><b>Total Price:</b> RM $totalPrice</p><p><b>Total Points:</b> $totalPoint points added</p>
    <br>--------------------------------------------------------------------------------------------------------------------------------------<br>– This invoice is computer-generated and requires no signature.<br>– For any inquiries, you can contact us through kidztechcentrecyberjaya@gmail.com .";

    // Display totals
    $content .= "</ul> ...";
} else {
    $content .= "<p>No product details found.</p>";
}

// Output the PDF to the browser or save it to a file
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output('invoice.pdf', 'I'); // 'I' sends the file inline to the browser
?>
