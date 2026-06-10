<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics</title>
    <link href="./css/styles.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                TechStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarContent">

                <!-- Left Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>

                <!-- Search -->
                <form class="d-flex search-box">
                    <input class="form-control me-2 rounded-3" type="search" placeholder="Search products...">
                    <button class="btn btn-dark rounded-3">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Right Icons -->
                <div class="d-flex align-items-center">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="account.php" class="nav-link">My Account</a>
                    <?php else: ?>
                        <a href="login.php" class="nav-link">Login</a>
                    <?php endif; ?>
                    <a href="cart.php" class="position-relative ms-3">
                        <i class="bi bi-cart3 fs-4 text-dark"></i>
                        <span class="badge bg-danger rounded-pill cart-badge">
                            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    </nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>