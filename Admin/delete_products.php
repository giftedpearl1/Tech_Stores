<?php
    include './includes/db.php';
    $message = "";

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "DELETE FROM products_table WHERE id=$id";
        $Result = mysqli_query($conn, $query);

        if(!$Result) {
            $message = "<p class='text-danger'>Failed to delete Product</p>";
        } else{
            $message = "<p class='text-success'>Product deleted successfully</p>";
        }
    }
?>

   <?php echo "$message";?>

