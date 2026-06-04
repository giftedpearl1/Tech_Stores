<?php
    include 'includes/db.php';
    session_start();

    if(isset($_POST['register'])) {

        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = mysqli_query($conn, "INSERT INTO admin_table(username, password) VALUES('$username', '$password')");

        if($query) {
            header("Location: admin_login.php");
        } else {
            $error = "Invalid credentials!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height:100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h4 class="mb-3 text-center">Admin Signup</h4>
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="POST">
                        <input type="username" name="username" class="form-control mb-3" placeholder="Username" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <button class="btn btn-dark w-100" name="register">Signup</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>