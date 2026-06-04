<?php
    include './includes/db.php';
    include './includes/header.php';

    //Pagination Setup
    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    // Search 
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $query = "SELECT products_table.*, category_table.title AS category_name
        FROM products_table
        JOIN category_table 
        ON products_table.category_id = category_table.id";

    if(!empty($search)){
        $query .= " WHERE products_table.product_name LIKE '%$search%'";
    }

    $query .= " LIMIT $start, $limit";

    $Result = mysqli_query($conn, $query);
?>

<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white rounded-top-4">
            <h5 class="mb-0">All Products</h5>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search product..." value="<?php echo $search; ?>">
                    <button class="btn btn-dark">Search</button>
                </div>
            </form>
            <!-- Product Cards -->
            <div class="row">
                <?php
                while($products = mysqli_fetch_assoc($Result)) {
                    $id = $products['id'];
                    $image = $products['image'];
                    $product_name = $products['product_name'];
                    $price = $products['price'];
                    $category_name = $products['category_name'];
                    $stock = $products['stock'];
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <img src="assets/uploads/<?php echo $image; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h6 class="fw-bold"><?php echo $product_name; ?></h6>
                            <p class="text-muted small"><?php echo $category_name; ?></p>
                            <h5>₦<?php echo $price; ?></h5>
                            <?php if($stock > 0) { ?>
                                <span class="badge bg-success">In Stock</span>
                            <?php } else { ?>
                                <span class="badge bg-danger">Out of Stock</span>
                            <?php } ?>
                            <div class="mt-3 d-flex justify-content-between">
                                <a href="edit_products.php?id=<?php echo $id; ?>" class="btn btn-sm btn-primary" name="edit">Edit</a>
                                <a href="delete_products.php?id=<?php echo $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <div class="mt-4 text-center">
                <?php
                $total_query = "SELECT COUNT(*) AS total FROM products_table";
                $total_result = mysqli_query($conn, $total_query);
                $total_row = mysqli_fetch_assoc($total_result);
                $total_pages = ceil($total_row['total'] / $limit);

                for($i = 1; $i <= $total_pages; $i++){
                    echo "<a class='btn btn-sm btn-outline-dark m-1' href='?page=$i&search=$search'>$i</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>