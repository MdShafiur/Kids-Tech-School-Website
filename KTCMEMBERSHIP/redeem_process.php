<?php
session_start();
if (isset($_SESSION["rec_id"])) {
    $recID = $_SESSION["rec_id"];
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
    exit();
}

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

$redeemPointsToDeduct = 0; 

if (isset($_POST['gift']) && is_array($_POST['gift'])) {
    foreach ($_POST['gift'] as $selectedGift) {
        // Retrieve redeem points for each selected gift
        $redeemQuery = "SELECT redeempoint FROM redeemlist WHERE redeemname = '$selectedGift'";
        $redeemResult = $conn->query($redeemQuery);

        if ($redeemResult && $redeemResult->num_rows > 0) {
            $redeemRow = $redeemResult->fetch_assoc();
            $redeemPointsToDeduct += intval($redeemRow['redeempoint']);
            
            // Insert the selected gift into the customerredeem table
            $insertCustomerRedeemQuery = "INSERT INTO customerredeem (rec_id, gift_name, redeempoint) VALUES ('$recID', '$selectedGift', '{$redeemRow['redeempoint']}')";
            if (!$conn->query($insertCustomerRedeemQuery)) {
                echo "Error inserting customer redeem record: " . $conn->error;
            }
        }
    }
}

// Retrieve the current total redeem points of the member
$currentRedeemPointsQuery = "SELECT totalpointpurchase FROM tbl_member WHERE rec_id = '$recID'";
$currentRedeemPointsResult = $conn->query($currentRedeemPointsQuery);

if ($currentRedeemPointsResult && $currentRedeemPointsResult->num_rows > 0) {
    $currentRedeemPointsRow = $currentRedeemPointsResult->fetch_assoc();
    $availablePoints = intval($currentRedeemPointsRow['totalpointpurchase']) - $redeemPointsToDeduct; // Subtract redeem points
    
    if ($availablePoints >= 0) {
        // Update the member's total redeem points
        $updateRedeemPointsQuery = "UPDATE tbl_member SET totalpointpurchase = '$availablePoints' WHERE rec_id = '$recID'";
        
        if ($conn->query($updateRedeemPointsQuery) === TRUE) {
            echo "Redeem points updated successfully.";
            echo '<script>setTimeout(function(){window.history.back();}, 2000);</script>';
        } else {
            echo "Error updating redeem points: " . $conn->error;
        }
    } else {
        echo '<script>alert("Error: You do not have enough points for redemption.");</script>';
        echo '<script>setTimeout(function(){window.history.back();}, 2000);</script>';
    }
} else {
    echo "Error retrieving current redeem points: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

