<?php
require_once './includes/db.php';
include './includes/header.php';

if(!isset($_GET['id'])){
    header('Location: shop.php');
    exit;
}

$product_id = (int) $_GET['id'];

// Fetch product
$stmt = $conn->prepare("SELECT products_table.*, category_table.title AS category_name FROM products_table JOIN category_table ON products_table.category_id = category_table.id WHERE products_table.id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "<div class='container py-5'><div class='alert alert-danger text-center'>Product not found.</div></div>";
    include './includes/footer.php';
    exit;
}

$product = $result->fetch_assoc();

// Fetch related products (same category)
$related_stmt = $conn->prepare("SELECT * FROM products_table WHERE category_id=? AND id!=? ORDER BY id DESC LIMIT 4");
$related_stmt->bind_param("ii", $product['category_id'], $product_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>

<div class="container py-5">
    <div class="row">

        <!-- Product Images -->
        <div class="col-lg-6">
            <div class="mb-3">
                <img id="mainImage" src="./Admin/assets/uploads/<?php echo $product['image']; ?>" class="img-fluid rounded-4 shadow-sm" style="width:100%; object-fit:contain; max-height:500px;">
            </div>
            <!-- Optional thumbnails, in future you can have multiple images -->
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <h2 class="fw-bold"><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <p class="text-muted mb-2">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>

            <!-- Price + Discount -->
            <div class="mb-3">
                <?php if(isset($product['discount_price']) && $product['discount_price'] > 0){ ?>
                    <span class="h4 fw-bold text-dark">$<?php echo number_format($product['discount_price'],2); ?></span>
                    <span class="text-muted text-decoration-line-through ms-2">$<?php echo number_format($product['price'],2); ?></span>
                <?php } else { ?>
                    <span class="h4 fw-bold text-dark">$<?php echo number_format($product['price'],2); ?></span>
                <?php } ?>
            </div>

            <!-- Stock -->
            <p class="mb-3"><?php echo ($product['stock'] > 0) ? "<span class='text-success'>In Stock</span>" : "<span class='text-danger'>Out of Stock</span>"; ?></p>

            <!-- Add to Cart -->
            <form action="cart.php" method="GET" class="d-flex align-items-center mb-4">
                <input type="hidden" name="add" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="form-control me-2" style="width:100px;">
                <button type="submit" class="btn btn-dark rounded-3 px-4">Add to Cart</button>
            </form>

            <!-- Product Description -->
            <div>
                <h5 class="fw-semibold">Product Description</h5>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Related Products</h4>
        <div class="row g-4">
            <?php
            if($related_result->num_rows > 0){
                while($related = $related_result->fetch_assoc()){
                    $product = $related; // reuse $product variable for product-card
                    include './includes/product_card.php';
                }
            } else {
                echo "<div class='col-12'><div class='alert alert-warning text-center'>No related products found.</div></div>";
            }
            ?>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>