<?php
    require_once './includes/db.php';
    include './includes/header.php';

    // CATEGORY FILTER

    if(isset($_GET['category'])) {
        $category_id = (int) $_GET['category'];
    } else {
        $category_id = 0;
    }

    // SEARCH

    if (isset($_GET['search'])) {
        $search = trim($_GET['search']);
    } else {
        $search = "";
    }

    // FETCH CATEGORIES

    $categories = $conn->query("SELECT * FROM category_table ORDER BY title ASC");

    // PRODUCT QUERY

    $sql = "SELECT * FROM products_table WHERE 1";

    $params = [];
    $types = "";

    if ($category_id > 0) {
        $sql .= " AND category_id = ?";
        $params[] = $category_id;
        $types .= "i";
    }

    if (!empty($search)) {
        $sql .= " AND product_name LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    $sql .= " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
?>


<div class="container py-5">
    <div class="row">

        <!-- CATEGORY SIDEBAR -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">

                    <h5 class="fw-bold mb-3">Categories</h5>

                    <ul class="list-unstyled">

                        <li>
                            <a href="shop.php"
                            class="text-decoration-none d-block py-2 <?php if($category_id == 0) echo 'fw-bold text-dark'; else echo 'text-muted'; ?>">
                                All Products
                            </a>
                        </li>

                        <?php while($cat = $categories->fetch_assoc()) { ?>

                            <li>
                                <a href="shop.php?category=<?php echo $cat['id']; ?>"
                                class="text-decoration-none d-block py-2 <?php if($category_id == $cat['id']) echo 'fw-bold text-dark'; else echo 'text-muted'; ?>">
                                    
                                    <?php echo htmlspecialchars($cat['title']); ?>

                                </a>
                            </li>

                        <?php } ?>

                    </ul>

                </div>
            </div>
        </div>


        <!-- PRODUCTS SECTION -->
        <div class="col-lg-9">

            <!-- SEARCH -->
            <form method="GET" class="mb-4">
                <div class="input-group input-group-lg shadow-sm">

                    <input type="text"
                        name="search"
                        class="form-control rounded-start-4"
                        placeholder="Search electronics..."
                        value="<?php echo htmlspecialchars($search); ?>">

                    <button class="btn btn-dark rounded-end-4">
                        Search
                    </button>

                </div>
            </form>


            <!-- PRODUCTS GRID -->
            <div class="row g-4">

                <?php
                if ($result->num_rows > 0) {

                    while($product = $result->fetch_assoc()) {

                        include './includes/product_card.php';

                    }

                } else {
                ?>

                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No products found.
                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>

    </div>
</div>


<?php include 'includes/footer.php'; ?>