<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["purchase"])) {
    $servername = "localhost";
    $username = "id19727041_ktcmembership";
    $password = "Ktcmembership123$";
    $dbname = "id19727041_ktcwebsite";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the form data
    $quantityData = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity-') === 0) {
            $programType = substr($key, strlen('quantity-'));
            $quantity = intval($value);
            if ($quantity > 0) {
                $quantityData[$programType] = $quantity;
            }
        }
    }

    // Process and insert the data into the "schoolprogrampurchase" table
    foreach ($quantityData as $programType => $quantity) {
        // Insert the data into the database using appropriate SQL queries
        $sql = "INSERT INTO schoolprogrampurchase (program_type, quantity) VALUES ('$programType', '$quantity')";

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            echo "Purchase completed successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>


