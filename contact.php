<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">Contact Us</h2>

    <div class="row">
        <div class="col-md-6 mb-4">
            <form method="POST" action="send_contact.php">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                </div>
                <div class="mb-3">
                    <textarea name="message" class="form-control" placeholder="Your Message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>

        <div class="col-md-6">
            <h5>Our Address</h5>
            <p>123 Tech Street, Lagos, Nigeria</p>
            <h5>Email</h5>
            <p>support@techstore.com</p>
            <h5>Phone</h5>
            <p>+234 800 123 4567</p>

            <div class="mt-4">
                <iframe src="https://maps.google.com/maps?q=lagos&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>