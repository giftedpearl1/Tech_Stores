<?php
    include './includes/db.php';
    $message = "";

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "DELETE FROM category_table WHERE id=$id";
        $result = mysqli_query($conn, $query);

        if(!$result) {
            $message = "<p class='text-danger'>Failed to delete category</p>";
        } else{
            $message = "<p class='text-success'>Category deleted successfully</p>";
        }
            header('Location: view_category.php');
    }
?>
    
