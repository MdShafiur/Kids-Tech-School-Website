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

// Get class details from the URL
$classDetailsJSON = isset($_GET['classDetails']) ? $_GET['classDetails'] : '[]';
$classDetails = json_decode($classDetailsJSON, true);

// Check if decoding was successful
if ($classDetails === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding class details JSON.');
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

if (!empty($classDetails)) {
    $content .= "<p><b>Class Details:</b></p><ul>";

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

    foreach ($classDetails as $detail) {
         
        $className = $detail['className'];
        $quantity = $detail['quantity'];

        $price = 0; // Set the default price
        $points = 0; // Set the default points
         

        $lowercaseClassName = strtolower($className);

        switch ($lowercaseClassName) {
            case 'programming dojo (per session)':
                $price = 45;
                $points = 45;
                break;
            case 'scratch game programming (per session)':
                $price = 45;
                $points = 45;
                break;
            case 'micro-bit (per session)':
                $price = 45;
                $points = 45;
                break;
            case 'micro-bit junior learning kit':
                $price = 150;
                $points = 150;
                break;
            case 'japan language class (monthly)':
                $price = 140;
                $points = 140;
                break;
            case 'japan language class (full)':
                $price = 700;
                $points = 700;
                break;
        }

        // Calculate the subtotal for each class
        $subtotalPrice = $quantity * $price;
        $subtotalPoint = $quantity * $points;

        // Add the subtotal to the total
        $totalPrice += $subtotalPrice;
        $totalPoint += $subtotalPoint;

      // class detail rows
     $content .= "
     <tr>
      <td>$className</td>
      <td>$price</td>  
      <td>$quantity</td>
      <td>$subtotalPrice</td>
      <td>$subtotalPoint</td>
     </tr> 
     ";  

    }

    $content .= "</table>";

    // Display the total price and total point
    $content .= "<br><br><br></ul><p><b>Total Price:</b> RM $totalPrice</p><p><b>Total Points:</b> $totalPoint points added</p>
    <br>--------------------------------------------------------------------------------------------------------------------------------------<br>– This invoice is computer-generated and requires no signature.<br>– For any inquiries, you can contact us through kidztechcentrecyberjaya@gmail.com .";

    // Display totals
    $content .= "</ul> ...";

} else {
    $content .= "<p>No class details found.</p>";
}

// Output the PDF to the browser or save it to a file
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output('invoice.pdf', 'I'); // 'I' sends the file inline to the browser
?>