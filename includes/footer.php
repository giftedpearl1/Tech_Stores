
<!-- Footer styling -->
 <style>
    .footer-link{
    color:#bbb;
    text-decoration:none;
    display:block;
    margin-bottom:8px;
    transition:0.3s;
    }

    .footer-link:hover{
    color:#fff;
    padding-left:5px;
    }

    /* SOCIAL ICONS */

    .social-icon{
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#222;
    border-radius:50%;
    color:#fff;
    font-size:18px;
    transition:0.3s;
    text-decoration:none;
    }

    .social-icon:hover{
    background:#fff;
    color:#000;
    transform:translateY(-5px);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    }

    /* Footer mobile */
        @media (max-width:768px){
        footer .row {
            display: flex;
            flex-direction: column;
        }

        .footer-brand {
            order: 4;
        }

        footer {
        text-align: center;
        }

        footer .d-flex.gap-3 {
            justify-content: center;
        }
    }
   
</style>



<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">

            <!-- BRAND -->
            <div class="col-md-3 mb-4 footer-brand">
                <h5 class="fw-bold">TechStore</h5>
                <p class="text-muted">
                Your trusted store for premium electronics, gadgets and accessories.
                </p>
                <div class="mt-3 d-flex gap-3">

                    <a href="#" class="social-icon">
                    <i class="bi bi-facebook"></i>
                    </a>

                    <a href="#" class="social-icon">
                    <i class="bi bi-linkedin"></i>
                    </a>

                    <a href="#" class="social-icon">
                    <i class="bi bi-whatsapp"></i>
                    </a>

                    <a href="#" class="social-icon">
                    <i class="bi bi-tiktok"></i>
                    </a>

                </div>  
            </div>

            <!-- SHOP LINKS -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Shop</h6>
                <ul class="list-unstyled">
                    <li><a href="shop.php" class="footer-link">All Products</a></li>
                    <li><a href="shop.php?category=1" class="footer-link">Phones</a></li>
                    <li><a href="shop.php?category=2" class="footer-link">Laptops</a></li>
                    <li><a href="shop.php?category=3" class="footer-link">Accessories</a></li>
                    <li><a href="shop.php?category=4" class="footer-link">Gaming</a></li>
                </ul>
            </div>

            <!-- COMPANY -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Company</h6>
                <ul class="list-unstyled">
                    <li><a href="home.php" class="footer-link">Home</a></li>
                    <li><a href="home.php#categories" class="footer-link">Categories</a></li>
                    <li><a href="contact.php" class="footer-link">Contact Us</a></li>
                    <li><a href="#" class="footer-link">About Us</a></li>
                </ul>
            </div>

            <!-- ACCOUNT -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Account</h6>
                <ul class="list-unstyled">
                    <li><a href="login.php" class="footer-link">Login</a></li>
                    <li><a href="register.php" class="footer-link">Register</a></li>
                    <li><a href="cart.php" class="footer-link">Cart</a></li>
                    <li><a href="checkout.php" class="footer-link">Checkout</a></li>
                </ul>
            </div>
                <hr class="border-secondary">
                <div class="text-center">
                <p class="mb-0">
                © <?php echo date("Y"); ?> TechStore. All rights reserved.
                </p>
                </div>  
        </div>
    </div>
</footer>