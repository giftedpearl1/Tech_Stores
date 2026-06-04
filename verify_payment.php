<?php
require_once './includes/db.php';
include './includes/header.php';

// Get Flutterwave response parameters
$status = $_GET['status'] ?? null;
$tx_ref = $_GET['tx_ref'] ?? null;
$transaction_id = $_GET['transaction_id'] ?? null;

// Check if transaction reference exists
if(!$tx_ref){
    echo "<div class='container py-5'><div class='alert alert-danger'>Invalid payment response.</div></div>";
    include './includes/footer.php';
    exit;
}

// If payment successful
if($status == "successful"){

    // Find order using tx_ref
    $stmt = $conn->prepare("SELECT * FROM orders_table WHERE tx_ref=?");
    $stmt->bind_param("s",$tx_ref);
    $stmt->execute();
    $result = $stmt->get_result();

    if($order = $result->fetch_assoc()){

        $order_id = $order['id'];

        // Update order status to paid
        $update = $conn->prepare("UPDATE orders_table SET status='paid' WHERE id=?");
        $update->bind_param("i",$order_id);
        $update->execute();

        echo "
        <div class='container py-5'>
            <div class='alert alert-success text-center'>
                <h3>Payment Successful 🎉</h3>
                <p>Your order #$order_id has been paid successfully.</p>
                <a href='shop.php' class='btn btn-primary mt-3'>Continue Shopping</a>
            </div>
        </div>
        ";

    } else {

        echo "
        <div class='container py-5'>
            <div class='alert alert-danger text-center'>
                Order not found.
            </div>
        </div>
        ";
    }

}else{

    echo "
    <div class='container py-5'>
        <div class='alert alert-danger text-center'>
            Payment was cancelled or failed.
            <br><br>
            <a href='checkout.php' class='btn btn-warning'>Try Again</a>
        </div>
    </div>
    ";
}

include './includes/footer.php';
?>