<?php
require_once __DIR__ . '/config/env.php';
require_once './includes/db.php';
include './includes/header.php';

// Check if cart is empty
if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<div class='alert alert-warning'>Your cart is empty. <a href='shop.php'>Shop now</a>.</div>";
    exit;
}

$message = "";


// Calculate cart items & total

$cart_items = [];
$total_amount = 0;

foreach($_SESSION['cart'] as $product_id => $qty){

    // Get product from database
    $stmt = $conn->prepare("SELECT * FROM products_table WHERE id=?");
    if(!$stmt) die("Prepare failed: ".$conn->error);

    $stmt->bind_param("i",$product_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if($product = $result->fetch_assoc()){

        $product['quantity'] = $qty;
        $product['subtotal'] = $product['price'] * $qty;

        $total_amount += $product['subtotal'];

        $cart_items[] = $product;
    }
}



// Handle checkout form

if(isset($_POST['place_order'])){

    $customer_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $payment_method = $_POST['payment_method'];

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders_table (customer_name,email,phone,address,city,state,total_amount,status,payment_method) VALUES (?,?,?,?,?,?,?,?,?)");

    if(!$stmt) die("Prepare failed: ".$conn->error);

    $status = "pending";

    $stmt->bind_param(
        "ssssssdss",
        $customer_name,
        $email,
        $phone,
        $address,
        $city,
        $state,
        $total_amount,
        $status,
        $payment_method
    );

    $stmt->execute();

    // Get order ID
    $order_id = $stmt->insert_id;


    // Insert order items

    foreach($cart_items as $item){

        $stmt_item = $conn->prepare("INSERT INTO orders_item_table (order_id,product_id,quantity) VALUES (?,?,?)");

        if(!$stmt_item) die("Prepare failed: ".$conn->error);

        $stmt_item->bind_param("iii",$order_id,$item['id'],$item['quantity']);
        $stmt_item->execute();
    }


  
    // Generate Flutterwave tx_ref

    $tx_ref = "ORDER_".time()."_".$order_id;

    $stmt_tx = $conn->prepare("UPDATE orders_table SET tx_ref=? WHERE id=?");

    if(!$stmt_tx) die("Prepare failed: ".$conn->error);

    $stmt_tx->bind_param("si",$tx_ref,$order_id);
    $stmt_tx->execute();


    // Flutterwave Payment Request

    $flutterwave_secret = getenv('FLUTTERWAVE_SECRET_KEY');
    
    // Redirect after payment
    $redirect_url = "https://techstores-production.up.railway.app/verify_payment.php";

    $payload = [

        "tx_ref" => $tx_ref,

        "amount" => number_format($total_amount,2,'.',''),

        "currency" => "NGN",

        "payment_options" => $payment_method,

        "redirect_url" => $redirect_url,

        "customer" => [

            "email" => $email,
            "name" => $customer_name,
            "phone_number" => $phone
        ],

        "customizations" => [

            "title" => "TechStore Order #$order_id",
            "description" => "Purchase of electronics items"
        ]
    ];


    // Initialize cURL
    $curl = curl_init();

    curl_setopt_array($curl,[

        CURLOPT_URL => "https://api.flutterwave.com/v3/payments",

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_POST => true,

        CURLOPT_POSTFIELDS => json_encode($payload),

        CURLOPT_HTTPHEADER => [

            "Authorization: Bearer $flutterwave_secret",
            "Content-Type: application/json"
        ],

        // Prevent script timeout
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10
    ]);

    $response = curl_exec($curl);

    // Show curl errors if any
    if(curl_errno($curl)){
        echo "Curl Error: ".curl_error($curl);
    }

    curl_close($curl);


    // Decode response
    $res = json_decode($response,true);


    // Redirect to Flutterwave
    if(isset($res['status']) && $res['status']=="success" && isset($res['data']['link'])){

        // Redirect customer to payment page
        header("Location: ".$res['data']['link']);
        exit;

    }else{

        echo "<pre>";
        print_r($res);
        echo "</pre>";
    }

}

?>


<div class="container py-5">
    <h2 class="fw-bold mb-4">Checkout</h2>
    <?php echo $message; ?>
    <div class="row">
            <!-- Customer form -->
        <div class="col-md-6 mb-4">
            
            <form method="POST">

                <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="state" class="form-control" placeholder="State" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="card">Card</option>
                        <option value="banktransfer">Bank Transfer</option>
                        <option value="ussd">USSD</option>
                    </select>
                </div>

                    <button type="submit" name="place_order" class="btn btn-success px-5 rounded-3">
                    Place Order & Pay
                    </button>

            </form>
        </div>


        <!-- Order summary -->
        <div class="col-md-6">

            <h4 class="mb-3">Order Summary</h4>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach($cart_items as $item){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₦<?php echo number_format($item['subtotal'],2); ?></td>
                    </tr>
                        <?php } ?>
                    <tr>
                        <td colspan="2" class="text-end fw-bold">Total</td>
                        <td>₦<?php echo number_format($total_amount,2); ?></td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>

</div>

<?php include './includes/footer.php'; ?>