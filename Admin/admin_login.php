<?php
include 'includes/db.php';
session_start();

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin_table WHERE username='$username'");

    if(mysqli_num_rows($query) > 0){
        $admin = mysqli_fetch_assoc($query);
        if(password_verify($password, $admin['password'])){
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h4 class="mb-3 text-center">Admin Login</h4>
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="POST">
                        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <button class="btn btn-dark w-100" name="login">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>