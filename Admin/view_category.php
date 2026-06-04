 <?php
    include './includes/header.php';
    include './includes/db.php';

?>
    <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between">
                <h5 class="mb-0">All Categories</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM category_table";
                                $result = mysqli_query($conn, $query);
                                
                                while($category = mysqli_fetch_assoc($result)) {
                                    $id = $category['id'];
                                    $title = $category['title'];

                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$title</td>";
                                    echo "<td>
                                    <div class='btn-group'>
                                        <a class='btn btn-primary' href='edit_category.php?id=$id'>Edit</a>
                                        <a class='btn btn-danger' href='delete_category.php?id=$id'>Delete</a>
                                    </div>
                                    </td>";
                                    echo "</tr>";                                    
                                } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php include './includes/footer.php'; ?>