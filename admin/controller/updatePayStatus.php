<?php
// Include the database connection file
include_once "../config/dbconnect.php";

// Validate and sanitize the order ID from the POST request
$orderId = filter_input(INPUT_POST, 'record', FILTER_SANITIZE_NUMBER_INT);

if ($orderId) {
     // Prepare the SQL statement to select the payment status
     $stmt = $conn->prepare("SELECT pay_status FROM orders WHERE order_id = ?");
     $stmt->bind_param("i", $orderId);
     $stmt->execute();
     $result = $stmt->get_result();
     $row = $result->fetch_assoc();

     if ($row) {
          // Determine the new payment status
          $newStatus = $row["pay_status"] == 0 ? 1 : 0;

          // Prepare the SQL statement to update the payment status
          $updateStmt = $conn->prepare("UPDATE orders SET pay_status = ? WHERE order_id = ?");
          $updateStmt->bind_param("ii", $newStatus, $orderId);
          $updateStmt->execute();

          if ($updateStmt->affected_rows > 0) {
               // echo "Payment status updated successfully.";
          } else {
               // echo "No changes made to the payment status.";
          }

          $updateStmt->close();
     } else {
          //  echo "Order not found.";
     }

     $stmt->close();
} else {
     //   echo "Invalid order ID.";
}

// Close the connection
$conn->close();
?>