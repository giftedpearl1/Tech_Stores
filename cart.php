<?php
require_once './includes/db.php';
include './includes/header.php'; // 

$message = "";

//Add to cart
if(isset($_GET['add'])){
    $product_id = (int) $_GET['add'];
    $quantity = isset($_GET['quantity']) ? (int) $_GET['quantity'] : 1;

    // Fetch product to ensure it exists
    $stmt = $conn->prepare("SELECT * FROM products_table WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $product = $result->fetch_assoc();
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        // If already in cart, increase quantity
        if(isset($_SESSION['cart'][$product_id])){
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        $message = "<p class='text-success'>Product added to cart!</p>";
    } else {
        $message = "<p class='text-danger'>Product not found!</p>";
    }

    header("Location: cart.php");
    exit;
}

// Update quantities
if(isset($_POST['update_cart'])){
    foreach($_POST['quantities'] as $id => $qty){
        $id = (int) $id;
        $qty = (int) $qty;
        if($qty <= 0){
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
    }
    $message = "<p class='text-success'>Cart updated!</p>";
}

// Remove item
if(isset($_GET['remove'])){
    $remove_id = (int) $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    $message = "<p class='text-success'>Item removed from cart!</p>";
    header("Location: cart.php");
    exit;
}

// Prepare cart items for display
$cart_items = [];
$total = 0;

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
    $ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products_table WHERE id IN ($ids)";
    $result = $conn->query($query);

    while($row = $result->fetch_assoc()){
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $row['subtotal'] = $row['price'] * $row['quantity']; // Use price only
        $total += $row['subtotal'];
        $cart_items[] = $row;
    }
}
?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Your Cart</h2>
    <?php echo $message; ?>

    <?php if(count($cart_items) > 0){ ?>
        <form method="POST">
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cart_items as $item){ ?>
                            <tr>
                                <td class="text-start">
                                    <img src="./Admin/assets/uploads/<?php echo $item['image']; ?>" style="height:50px; object-fit:contain;" class="me-2">
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </td>
                                <td>$<?php echo number_format($item['price'],2); ?></td>
                                <td>
                                    <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" class="form-control text-center" style="width:70px;">
                                </td>
                                <td>$<?php echo number_format($item['subtotal'],2); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger">Remove</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <button type="submit" name="update_cart" class="btn btn-dark px-4 rounded-3">Update Cart</button>
                <h4>Total: $<?php echo number_format($total,2); ?></h4>
            </div>

            <div class="text-end">
                <a href="checkout.php" class="btn btn-success px-5 rounded-3">Proceed to Checkout</a>
            </div>
        </form>
    <?php } else { ?>
        <div class="alert alert-warning text-center">Your cart is empty. <a href="shop.php">Continue shopping</a>.</div>
    <?php } ?>
</div>

<?php include './includes/footer.php'; ?>