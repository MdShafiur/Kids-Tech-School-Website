<?php
session_start();
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
} else {
    session_unset();
    session_write_close();
    $url = "./index.php";
    header("Location: $url");
    exit;
}
?>

<!-- Existing code for product display -->

<!-- Display all purchases made by the user -->
<h2>Your Purchases</h2>
<table>
<thead>
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Purchase Date</th>
    </tr>
</thead>
<tbody>
<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "ktcwebsite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the purchase details from the "productpurchase" table for the logged-in user
$purchaseQuery = "SELECT product_name, quantity, price, purchase_date FROM productpurchase WHERE email = ?";
$stmt = $conn->prepare($purchaseQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>RM " . number_format($row['price'], 2) . "</td>";
        echo "<td>" . $row['purchase_date'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No purchases found.</td></tr>";
}

$stmt->close();
$conn->close();
?>
</tbody>
</table>

<!-- Remaining HTML and PHP code -->
