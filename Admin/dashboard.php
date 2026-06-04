<?php
    require_once '../includes/db.php';
    include '../includes/header.php';

    // Get dashboard statistics

    $total_orders = $conn->query("SELECT COUNT(*) AS total FROM orders_table")->fetch_assoc()['total'];
    $paid_orders = $conn->query("SELECT COUNT(*) AS total FROM orders_table WHERE status='paid'")->fetch_assoc()['total'];
    $pending_orders = $conn->query("SELECT COUNT(*) AS total FROM orders_table WHERE status='pending'")->fetch_assoc()['total'];

    // Total revenue
    $revenue_result = $conn->query("SELECT SUM(total_amount) AS revenue FROM orders_table WHERE status='paid'");
    $revenue = $revenue_result->fetch_assoc()['revenue'] ?? 0;

    // Latest orders
    $latest_orders = $conn->query("SELECT * FROM orders_table ORDER BY id DESC LIMIT 10");
?>

<div class="container-fluid">
    <div class="row">
        <!-- Side bar -->
        <div class="col-md-2 bg-dark text-white min-vh-100 p-3">
            <h4 class="mb-4">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="dashboard.php">Orders</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="view_products.php">Products</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="add_products.php">Add Product</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="../shop.php">View Store</a>
                </li>
            </ul>
        </div>


        <!-- Main Dashboard -->
        <div class="col-md-10 p-4">
        <h2 class="mb-4">Dashboard</h2>

        <!-- Stat cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5>Total Orders</h5>
                        <h3><?php echo $total_orders; ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5>Paid Orders</h5>
                        <h3 class="text-success"><?php echo $paid_orders; ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5>Pending Orders</h5>
                        <h3 class="text-warning"><?php echo $pending_orders; ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5>Total Revenue</h5>
                        <h3 class="text-primary">₦<?php echo number_format($revenue,2); ?></h3>
                    </div>
                </div>
            </div>
        </div>

      <!-- Recent Orders -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = $latest_orders->fetch_assoc()){ ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['email']); ?></td>
                            <td>₦<?php echo number_format($order['total_amount'],2); ?></td>
                            <td><?php echo ucfirst($order['payment_method']); ?></td>
                            <td>
                                <?php if($order['status'] == 'paid'){ ?>
                                <span class="badge bg-success">Paid</span>
                                <?php }else{ ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                                <?php } ?>
                            </td>
                            <td><?php echo $order['created_at'] ?? ''; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>