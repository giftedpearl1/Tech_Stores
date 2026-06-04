<?php
    include './includes/db.php';
    include './includes/header.php';
    $message = "";

    if(isset($_POST['add_product'])) {
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];

       $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        // create unique name
        $image = time() . "_" . $image;

        // upload path
        $upload_path = "assets/uploads/" . $image;

        // move file
        if(move_uploaded_file($tmp_name, $upload_path)){
            // upload successful
        }else{
            echo "<p style='color:red;'>Image upload failed</p>";
        }
        
        $query = "INSERT INTO products_table(product_name, price, stock, category_id, description, image) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $product_name, $price, $stock, $category_id, $description, $image);
        $Result = $stmt->execute();

        if(!$Result) {
            $message = "<p class='text-danger'>Failed to add product!</p>";
        } else {
            $message = "<p class='text-success'>Product added successfully!</p>";
        }
            header('Location: view_products.php');
    }

?>


<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <!-- Header -->
                <div class="card-header bg-white border-0 rounded-top-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0">Add New Product</h4>
                            <small class="text-muted">Enter Product details</small>
                        </div>
                        <span class="badge bg-dark px-3 py-2">Admin Panel</span>
                    </div>
                </div>
                <!-- Body -->
                <div class="card-body p-5">
                 <?php echo "$message"; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- Product Name -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control rounded-3" name="product_name" placeholder="Product Name" required>
                            <label>Product Name</label>
                        </div>
                        <!-- Price & Quantity Row -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" name="price" placeholder="Price" required>
                                    <label>Product Price (₦)</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control rounded-3" name="stock" placeholder="Quantity" required>
                                    <label>Stock Quantity</label>
                                </div>
                            </div>
                        </div>
                        <!-- Category -->
                        <div class="form-floating mb-4">
                            <select class="form-select rounded-3" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php
                                $query = "SELECT * FROM category_table"; 
                                $Result = mysqli_query($conn, $query);

                                while($category = mysqli_fetch_assoc($Result)){
                                    $id = $category['id'];
                                    $title = $category['title'];
                                ?>
                                    <option value="<?php echo $id; ?>">
                                        <?php echo $title; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <label>Product Category</label>
                        </div>
                        <!-- Description -->
                        <div class="form-floating mb-4">
                            <textarea class="form-control rounded-3" name="description" placeholder="Description" style="height:120px;"></textarea>
                            <label>Product Description</label>
                        </div>
                        <!-- Divider -->
                        <hr class="my-4">
                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Product Image</label>
                            <input type="file" class="form-control rounded-3" name="image" id="imageInput" required>
                        </div>
                        <!-- Image Preview -->
                        <div class="text-center mb-4">
                            <img id="previewImage" src="#" class="img-fluid rounded-3 shadow-sm d-none" style="max-height:200px; object-fit:contain;">
                        </div>
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-outline-secondary px-4 rounded-3">
                                Cancel
                            </a>
                            <button type="submit" name="add_product" class="btn btn-dark px-5 rounded-3 shadow-sm">
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Image Preview Script -->
<script>
document.getElementById("imageInput").addEventListener("change", function(e) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById("previewImage");
        preview.src = reader.result;
        preview.classList.remove("d-none");
    }
    reader.readAsDataURL(e.target.files[0]);
});
</script>

   <?php include './includes/footer.php'; ?>





 