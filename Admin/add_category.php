<?php
include './includes/db.php';
    $message = "";

    if(isset($_POST['add_category'])) {
        $title = $_POST['title'];

        if(!empty($title)) {
            $query = "INSERT INTO category_table(title) VALUES(?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $title);
            $Result = $stmt->execute();

            if(!$Result) {
                $message = "<p class='text-danger'>Failed to add category</p>";
            } else {
                $message = "<p class='text-success'>Category added successfully</p>";
            }
                header('Location: view_category.php');
        }
        
    }

?>

<?php include './includes/header.php'; ?>

<div class="container-fluid py-4"> 
    <div class="row justify-content-center">
        <!-- LEFT: Add Category Form -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white rounded-top-4">
                    <h5 class="mb-0">Add New Category</h5>
                </div>
                <div class="card-body p-4">
                    <?php echo "$message";?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category Title</label>
                            <input type="text" name='title' class="form-control form-control-lg" placeholder="Enter category name" required>
                        </div>
                        <button name="add_category" type="submit" class="btn btn-dark w-100 btn-lg">Add Category</button>
                    </form>
                </div>
            </div>
        </div>

<?php include './includes/footer.php'; ?>
       