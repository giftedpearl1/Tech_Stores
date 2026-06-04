

<div class="col-md-6 col-lg-4">
    <div class="card product-card border-0 shadow-sm rounded-4 h-100">

        <div class="position-relative overflow-hidden rounded-top-4">

            <a href="product.php?id=<?php echo $product['id']; ?>">
                <img src="./Admin/assets/uploads/<?php echo $product['image']; ?>"
                     class="card-img-top product-img"
                     alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </a>

            <!-- Discount Badge (optional) -->
            <?php if(isset($product['discount_price']) && $product['discount_price'] > 0) { ?>
                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                    SALE
                </span>
            <?php } ?>

            <!-- Add To Cart Overlay -->
            <div class="product-overlay">
                <a href="cart.php?add=<?php echo $product['id']; ?>"
                   class="btn btn-light btn-sm rounded-pill px-4">
                   Add to Cart
                </a>
            </div>

        </div>

        <div class="card-body text-center">

            <h6 class="fw-semibold mb-2">
                <?php echo htmlspecialchars($product['product_name']); ?>
            </h6>

            <!-- Star Rating UI -->
            <div class="text-warning mb-2">
                ★★★★☆
            </div>

            <!-- Price -->
            <h5 class="fw-bold text-dark">

                <?php if(isset($product['discount_price']) && $product['discount_price'] > 0) { ?>

                    <span class="text-muted text-decoration-line-through me-2">
                        $<?php echo number_format($product['price'],2); ?>
                    </span>

                    $<?php echo number_format($product['discount_price'],2); ?>

                <?php } else { ?>

                    $<?php echo number_format($product['price'],2); ?>

                <?php } ?>

            </h5>

        </div>

    </div>
</div>