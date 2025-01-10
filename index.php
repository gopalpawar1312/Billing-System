<?php
include 'db_connection.php';

// Query to get total sales and revenue
$total_sales_query = "SELECT SUM(quantity) as total_sales FROM billing";
$result_sales = $conn->query($total_sales_query);
$total_sales = $result_sales->fetch_assoc()['total_sales'] ?? 0;

$total_revenue_query = "
SELECT SUM(b.quantity * p.price) as total_revenue
FROM billing b
JOIN products p ON b.product_id = p.id";
$result_revenue = $conn->query($total_revenue_query);
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
body {
    background-color: #eef1f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Navbar */
/* Navbar Container Styling */
.navbar {
    background-color: #f8f9fa;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1000;
}

.navbar-brand {
    font-weight: bold;
    font-size: 26px;
    color: #007bff;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: color 0.3s ease;
}

.navbar-brand:hover {
    color: #0056b3;
}

/* Navbar collapse */
.navbar-collapse {
    justify-content: space-between;
}

/* Search Box Styling */
.search-box {
    max-width: 350px;
    transition: box-shadow 0.3s ease;
}

.search-box input {
    border-radius: 20px;
    border: 1px solid #ddd;
    padding: 10px 15px;
    transition: all 0.3s ease;
    box-shadow: none;
}

.search-box input:focus {
    outline: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.search-box button {
    border-radius: 20px;
    padding: 10px 20px;
    border-color: #28a745;
    background-color: #28a745;
    color: white;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.search-box button:hover {
    background-color: #218838;
}

/* Navbar Right-Side Icons */
.navbar-nav .nav-link {
    color: #333;
    font-weight: 500;
    margin-right: 15px;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
}

.navbar-nav .nav-link i {
    margin-right: 8px;
    font-size: 18px;
    transition: transform 0.3s ease;
}

.navbar-nav .nav-link:hover i {
    transform: scale(1.2);
    color: #007bff;
}

.navbar-nav .nav-link {
    position: relative;
    padding-right: 20px;
}

.navbar-nav .badge {
    font-size: 12px;
    padding: 3px 8px;
    border-radius: 12px;
    position: absolute;
    top: -1px; 
    right: 95px; 
    transform: none; 
    background-color: red;
    color: white;
}

@media (max-width: 992px) {
    .search-box {
        max-width: 100%;
        margin-top: 10px;
    }

    .navbar-collapse {
        justify-content: center;
    }

    .navbar-nav {
        justify-content: center;
        margin-top: 10px;
    }
}

@media (max-width: 768px) {
    .navbar-collapse {
        justify-content: flex-start;
    }
}


/* Card Styles */
.card {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.card:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

.card h2 {
    margin-top: 10px;
    font-size: 38px;
    color: #fff;
}

/* Quick Links List Group as Card Format */
.list-group-item {
    display: flex;
    align-items: center;
    padding: 20px;
    background-color: #fff;
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-bottom: 15px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.list-group-item:hover {
    background-color: #f9f9f9;
    transform: translateY(-5px);
}

.list-group-item i {
    margin-right: 15px;
    font-size: 24px;
    color: #007bff;
    transition: transform 0.3s ease;
}

.list-group-item:hover i {
    transform: scale(1.2);
}

.list-group-item h4 {
    margin: 0;
    font-size: 20px;
    font-weight: bold;
    color: #333;
}

/* AOS Animations */
[data-aos] {
    transition-property: opacity, transform;
}

[data-aos="fade-up"] {
    transform: translateY(20px);
    opacity: 0;
    transition-timing-function: ease-out;
}

[data-aos="fade-up"].aos-animate {
    transform: translateY(0);
    opacity: 1;
}

/* Colors and Effects */
.bg-primary {
    background: linear-gradient(135deg, #6f86d6, #48c6ef);
}

.bg-success {
    background: linear-gradient(135deg, #56ab2f, #a8e063);
}

h3 {
    color: #007bff;
    font-weight: bold;
    margin-bottom: 20px;
}

.search-results h3 {
    color: #333;
}

.transition-effect:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

    </style>
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Inventory System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex search-box" method="GET" action="search.php">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-bell"></i> Notifications <span class="badge bg-danger">3</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user"></i> Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   
    <div class="container mt-5">
        <div class="row">
          
            <div class="col-lg-3 col-sm-6">
                <div class="card bg-primary text-white mb-4 transition-effect">
                    <div class="card-body">
                        Total Sales
                        <h2><?php echo $total_sales; ?></h2>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-3 col-sm-6">
                <div class="card bg-success text-white mb-4 transition-effect">
                    <div class="card-body">
                        Total Revenue
                        <h2>$<?php echo number_format($total_revenue, 2); ?></h2>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="row mt-4">
        <div class="card" data-aos="fade-up">
                <h3>Quick Links</h3>
                <div class="list-group">
                    <a href="add_customer.php" class="list-group-item list-group-item-action transition-effect">
                        <i class="fas fa-user-plus"></i> Add Customer
                    </a>
                    <a href="add_product.php" class="list-group-item list-group-item-action transition-effect">
                        <i class="fas fa-box-open"></i> Add Product
                    </a>
                    <a href="add_billing.php" class="list-group-item list-group-item-action transition-effect">
                        <i class="fas fa-receipt"></i> Billing System
                    </a>
                    <a href="customers.php" class="list-group-item list-group-item-action transition-effect">
                        <i class="fas fa-users"></i> View Customers
                    </a>
                    <a href="inventory.php" class="list-group-item list-group-item-action transition-effect">
                        <i class="fas fa-boxes"></i> View Products
                    </a>
                </div>
            </div>
        </div>

        
        <?php if (isset($_GET['query'])): ?>
            <div class="container search-results">
                <h3>Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h3>
                
            </div>
        <?php endif; ?>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
