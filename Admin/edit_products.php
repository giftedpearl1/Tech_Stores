<?php
    include './includes/header.php';
    include './includes/db.php';
    $message = "";

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT products_table.*, category_table.title AS category_name
        FROM products_table
        JOIN category_table 
        ON products_table.category_id = category_table.id
        WHERE products_table.id = $id";

        $Result = mysqli_query($conn, $query);

        if($product = mysqli_fetch_assoc($Result)) {
            $image = $product['image'];
            $product_name = $product['product_name'];
            $price = $product['price'];
            $category_id = $product['category_id'];
            $stock = $product['stock'];
            $description = $product['description'];
        }
    }

    if(isset($_POST['edit'])) {
        $id = $_GET['id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];

        // check if new image uploaded
        if(!empty($_FILES['image']['name'])){

            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            $image = time() . "_" . $image;

            move_uploaded_file($tmp_name, "assets/uploads/".$image);

            $query = "UPDATE products_table 
            SET image='$image', product_name='$product_name', price='$price', category_id='$category_id', stock='$stock', description='$description'
            WHERE id=$id";

        } else {

            $query = "UPDATE products_table 
            SET product_name='$product_name', price='$price', category_id='$category_id', stock='$stock', description='$description'
            WHERE id=$id";
        }

        $Result = mysqli_query($conn, $query);

        if(!$Result){
            $message = "<p class='text-danger lead'>Failed to update product</p>";
        }else{
            $message = "<p class='text-success lead'>Product updated successfully!</p>";
        }
        header('Location: view_products.php');
    }
?>

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 rounded-top-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0">Edit Product</h4>
                            <small class="text-muted">Edit Product details</small>
                        </div>
                        <span class="badge bg-dark px-3 py-2">Admin Panel</span>
                    </div>
                </div>
                
                <div class="card-body p-5">
                    <?php echo $message; ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control rounded-3" name="product_name" placeholder="Product Name" value="<?php echo $product_name?>" required>
                            <label>Product Name</label>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" name="price" placeholder="Price" value="<?php echo $price?>" required>
                                    <label>Product Price (₦)</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control rounded-3" name="stock" placeholder="Quantity" value="<?php echo $stock?>" required>
                                    <label>Stock Quantity</label>
                                </div>
                            </div>
                        </div>

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
                                <option value="<?php echo $id; ?>" <?php if($id == $category_id) echo "selected"; ?>>
                                    <?php echo $title; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <label>Product Category</label>
                        </div>

                        <div class="form-floating mb-4">
                            <textarea class="form-control rounded-3" name="description" placeholder="Description" style="height:120px;"><?php echo $description?></textarea>
                            <label>Product Description</label>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Product Image</label>
                            <input type="file" class="form-control rounded-3" name="image" id="imageInput">
                        </div>

                        <div class="text-center mb-4">
                            <img id="previewImage" src="assets/uploads/<?php echo $image; ?>" class="img-fluid rounded-3 shadow-sm" style="max-height:200px; object-fit:contain;">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-outline-secondary px-4 rounded-3">Cancel</a>
                            <button type="submit" name="edit" class="btn btn-dark px-5 rounded-3 shadow-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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