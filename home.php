<?php
    require_once './includes/db.php';   
    include './includes/header.php';

    // Get hero product
    $stmt = $conn->prepare("SELECT * FROM products_table ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $hero = $stmt->get_result()->fetch_assoc();

    // Get categories
    $categories = $conn->query("SELECT * FROM category_table");

    // Get featured products
    $products = $conn->query("SELECT * FROM products_table ORDER BY id DESC LIMIT 8");
?>


<style>

    /* HERO */

    /* FLOATING BUTTON CONTAINER */
    .floating-actions {
        position: absolute;
        top: 60%;
        left: 92%; /* 👈 tweak this value */
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        gap: 150px;
        z-index: 10;
    }

    /* BUTTON STYLE */
    .floating-btn {
        width: 60px;
        height: 60px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 20px;
        color: #000;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        
        animation: bounce 2s infinite;
        transition: 0.3s;
    }

    /* HOVER EFFECT */b
    .floating-btn:hover {
        background: #fff;
        color: #000;
        transform: scale(1.1);
    }

    /* BOUNCING ANIMATION */
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }


    .hero-product{
    transition:0.4s;
    }

    .hero-product:hover{
    transform:translateY(-12px);
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
    }

    /* CATEGORY */

    .category-card{
    transition:0.3s;
    cursor:pointer;
    }

    .category-card:hover{
    background:#000;
    color:#fff;
    transform:translateY(-6px);
    }


    /* FLASH SALE HERO (NiceShop Style) */

    /* FLASH BADGE */

    .flash-pill{
    display:inline-block;
    background:#000;
    color:#fff;
    padding:8px 18px;
    border-radius:50px;
    font-size:13px;
    font-weight:600;
    letter-spacing:0.5px;
    margin-bottom:15px;
    }

    .flash-hero {
    background: linear-gradient(135deg, #f5f5f5, #eaeaea);
    padding: 80px 0;
    text-align: center;
    }

    .flash-hero h1 {
    font-size: 48px;
    font-weight: 700;
    }

    .flash-hero p {
    color: #777;
    max-width: 600px;
    margin: 15px auto;
    }

    .flash-countdown {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
    flex-wrap: wrap;
    }

    .flash-box {
    background: white;
    padding: 20px;
    border-radius: 12px;
    width: 100px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .flash-box h2 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
    }

    .flash-box span {
    font-size: 12px;
    color: #888;
    }

    .flash-btns {
    margin-top: 30px;
    }

    .flash-btns .btn {
    padding: 12px 25px;
    border-radius: 8px;
    }

    /* PRODUCT */

    .product-card{
    transition:0.3s;
    }

    .product-card:hover{
    transform:translateY(-10px);
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
    }

    /* TESTIMONIAL */

    .testimonial{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    }

    /* TESTIMONIAL */

    .testimonial{
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    max-width:600px;
    margin:auto;
    }

    .testimonial img{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:15px;
    }

    .testimonial .stars{
    color:#f5b301;
    font-size:18px;
    margin-bottom:10px;
    }

    @media (max-width: 768px) {
        .floating-actions {
            position: fixed;
            right: 15px;
            left: auto;
            top: auto;
            bottom: 20px;
            gap: 15px;
            z-index: 999;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
            font-size: 18px;
        }
    }

    /* FLASH SALE MOBILE */
    .flash-hero h1 {
        font-size: 2rem;
    }

    .flash-hero p {
        font-size: 15px;
        padding: 0 10px;
    }

    .flash-box {
        width: 75px;
        padding: 12px;
    }

    .flash-box h2 {
        font-size: 20px;
    }

    .flash-countdown {
        gap: 10px;
    }

    /* NEWSLETTER MOBILE */
    .bg-dark form {
        row-gap: 12px;
    }

    .bg-dark form .col-md-4,
    .bg-dark form .col-md-2 {
        width: 100%;
    }

    .bg-dark form button {
        height: 50px;
    }

    /* CONTACT MOBILE */
    @media (max-width:768px){
        .py-5 .col-md-6:last-child {
            margin-top: 30px;
        }

        .category-card {
        padding: 20px 10px !important;
        }

        .category-card h5 {
            font-size: 16px;
        }
    }

</style>


<!-- HERO SECTION -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center position-relative">
            <!-- FLOATING ACTION BUTTONS -->
            <div class="floating-actions">
                <!-- CART BUTTON -->
                <a href="cart.php" class="floating-btn">
                    🛒
                </a>

                <!-- SEARCH BUTTON -->
                <a href="shop.php" class="floating-btn">
                    🔍
                </a>

            </div>
            <div class="col-md-6">

                <h1 class="fw-bold display-4">
                    Premium Electronics Store
                </h1>
                <p class="text-muted mt-3">
                    Discover the latest gadgets, smart devices and accessories at the best price.
                </p>

                <div class="mt-4">
                    <a href="shop.php" class="btn btn-dark me-2">
                    Shop Now
                    </a>
                    <a href="#categories" class="btn btn-outline-dark">
                    Browse Categories
                    </a>
                </div>

                <div class="mt-5 d-flex flex-wrap gap-3">
                    <div class="me-4">🚚 Free Shipping</div>
                    <div class="me-4">✔ Quality Guarantee</div>
                    <div>🎧 24/7 Support</div>
                </div>
            </div>

            <div class="col-md-6 text-center">

                <?php if($hero){ ?>

                <div class="card border-0 shadow hero-product p-3">

                    <img src="./Admin/assets/uploads/<?php echo $hero['image']; ?>"
                    class="img-fluid"
                    style="max-height:350px;object-fit:contain;">

                    <div class="card-body">
                        <h5 class="fw-bold">
                        <?php echo htmlspecialchars($hero['product_name']); ?>
                        </h5>

                        <p class="text-muted fs-5">
                        ₦<?php echo number_format($hero['price'],2); ?>
                        </p>

                        <a href="product.php?id=<?php echo $hero['id']; ?>" class="btn btn-primary btn-sm">
                        View Product
                        </a>
                    </div>
                </div>

             <?php } ?>

            </div>

        </div>

    </div>

</section>


<!-- CATEGORIES -->
<section id="categories" class="py-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-5">Shop by Category</h3>
        <div class="row">

            <?php while($cat = $categories->fetch_assoc()){ ?>

            <div class="col-6 col-md-3 mb-4">
                <a href="shop.php?category=<?php echo $cat['id']; ?>" class="text-decoration-none">
                    <div class="card category-card border-0 shadow-sm p-4 text-center">
                        <h5 class="fw-bold">
                            <?php echo htmlspecialchars($cat['title']); ?>
                        </h5>
                    </div>
                </a>

            </div>
            <?php } ?>
        </div>
    </div>
</section>



<!-- FLASH SALE HERO -->
<section class="flash-hero">
    <div class="container">
        <span class="flash-pill">
            Limited time 50% OFF
        </span>
        <h1>Exclusive Flash Sale</h1>
        <p>
            Don't miss out on our biggest sale of the year.
            Premium quality products at unbeatable prices for the next 48 hours only.
        </p>

        <!-- COUNTDOWN -->
        <div class="flash-countdown">
            <div class="flash-box">
                <h2 id="days">-58</h2>
                <span>DAYS</span>
            </div>
            <div class="flash-box">
                <h2 id="hours">-6</h2>
                <span>HOURS</span>
            </div>
            <div class="flash-box">
                <h2 id="minutes">-35</h2>
                <span>MINUTES</span>
            </div>
            <div class="flash-box">
                <h2 id="seconds">-42</h2>
                <span>SECONDS</span>
            </div>
        </div>
            <!-- BUTTONS -->
        <div class="flash-btns">
            <a href="shop.php" class="btn btn-dark me-2">
            Shop Now
            </a>
            <a href="shop.php" class="btn btn-outline-dark">
            View All Deals
            </a>
        </div>
    </div>
</section>


<!-- FEATURED PRODUCTS -->

<section class="bg-light py-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-5">Featured Products</h3>
        <div class="row">
            <?php while($product = $products->fetch_assoc()){ ?>
            <div class="col-6 col-md-3 mb-4">
                <div class="card product-card border-0 h-100">
                    <img src="./Admin/assets/uploads/<?php echo $product['image']; ?>"
                    class="card-img-top"
                    style="height:200px;object-fit:contain;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">
                            <?php echo htmlspecialchars($product['product_name']); ?>
                        </h6>

                        <p class="text-muted">
                            ₦<?php echo number_format($product['price'],2); ?>
                        </p>

                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-dark">
                            View
                        </a>

                        <a href="cart.php?id=<?php echo $product['id']; ?>"
                        class="btn btn-sm btn-success">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>

            <!-- QUICK VIEW MODAL -->
            <div class="modal fade" id="quickView<?php echo $product['id']; ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="/assets/uploads/<?php echo $product['image']; ?>"
                                    class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <h4><?php echo $product['product_name']; ?></h4>
                                    <p class="text-muted">₦<?php echo number_format($product['price'],2); ?></p>
                                    <p><?php echo $product['description'] ?? ''; ?></p>
                                    <a href="product.php?id=<?php echo $product['id']; ?>"
                                    class="btn btn-dark">View Full Product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>

        </div>
    </div>
</section>



<!-- TESTIMONIALS -->
<section class="py-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-5">What Customers Say</h3>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <!-- TESTIMONIAL 1 -->
                <div class="carousel-item active">
                    <div class="testimonial text-center">
                        <img src="img/testimonia1.jpg">
                        <div class="stars">
                            ★★★★★
                        </div>
                        <p class="mt-2">
                            Amazing store! Fast delivery and original products.
                            I bought my headphones here and they arrived perfectly.
                        </p>
                        <strong>Chinedu Okafor</strong>
                        <br>
                        <small class="text-muted">Lagos, Nigeria</small>
                    </div>
                </div>

                <!-- TESTIMONIAL 2 -->
                <div class="carousel-item">
                    <div class="testimonial text-center">
                        <img src="img/testimonial2.jpg">
                        <div class="stars">
                            ★★★★★
                        </div>
                        <p class="mt-2">
                            Great prices and excellent customer service.
                            The laptop I ordered works perfectly.
                        </p>
                        <strong>Sarah Johnson</strong>
                        <br>
                        <small class="text-muted">Abuja, Nigeria</small>
                    </div>
                </div>

                <!-- TESTIMONIAL 3 -->
                <div class="carousel-item">
                    <div class="testimonial text-center">
                        <img src="img/testimonial3.jpg">
                        <div class="stars">
                            ★★★★★
                        </div>
                        <p class="mt-2">
                            My gadgets arrived quickly and in perfect condition.
                            I will definitely shop here again.
                        </p>
                        <strong>David Williams</strong>
                        <br>
                        <small class="text-muted">Port Harcourt, Nigeria</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- NEWSLETTER -->
<section class="bg-dark text-white py-5">
    <div class="container text-center">
        <h3 class="fw-bold">Subscribe to Our Newsletter</h3>
        <p>Get updates about new products and discounts</p>
        <form class="row justify-content-center">
            <div class="col-md-4">
                <input type="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100">
                Subscribe
                </button>
            </div>
        </form>
    </div>
</section>


<!-- CONTACT -->
<section class="py-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-4">Contact Us</h3>
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Full Name">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" rows="4" placeholder="Message"></textarea>
                    </div>
                    <button class="btn btn-dark">
                        Send Message
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <h6>Address</h6>
                <p>Port Harcourt, Nigeria</p>
                <h6>Email</h6>
                <p>support@techstore.com</p>
                <h6>Phone</h6>
                <p>+234 800 123 4567</p>
            </div>
        </div>
    </div>
</section>

<?php include './includes/footer.php'; ?>