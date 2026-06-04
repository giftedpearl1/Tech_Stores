<?php 
    include './includes/db.php';
    include './includes/header.php';


    $mesage = "";

    // getting category details 
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT * FROM category_table";
        $Result = mysqli_query($conn, $query);

        if($category = mysqli_fetch_assoc($Result)) {
            $id = $category['id'];
            $title = $category['title'];
        } 
    }

    // updating the category 
    if(isset($_POST['edit_category'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];

        $query = "UPDATE category_table SET title ='$title' WHERE id=$id";
        $Result = mysqli_query($conn, $query);

        if(!$Result) {
            $message = "<p class='text-danger'>Failed to update Category</p>";
        } else{
            $message = "<p class='text-success'>Category Updated successfully</p>";
        }
    }
?>

<?php echo $message; ?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="mb-3">
        <label class="form-label fw-semibold">Category Title</label>
        <input type="text" name='title' class="form-control form-control-lg" placeholder="Edit category title" value="<?php echo $title; ?>" required>
    </div>
    <button name="edit_category" type="submit" class="btn btn-dark w-100 btn-lg">Edit Category</button>
</form>

   <?php include './includes/footer.php';?>


