<?php
include 'db_connection.php';

$search_results = ''; // Initialize variable to hold search results

if (isset($_GET['query'])) {
    $search_query = htmlspecialchars($_GET['query']);

    // Prepare SQL queries for customers and products
    $search_customers_sql = "SELECT 'Customer' AS type, name, contact AS details, email FROM customers WHERE name LIKE '%$search_query%'";
    $search_products_sql = "SELECT 'Product' AS type, name, price AS details, '' AS email FROM products WHERE name LIKE '%$search_query%'";

    // Combine SQL queries
    $combined_sql = $search_customers_sql . " UNION " . $search_products_sql;

    // Execute query
    $result = $conn->query($combined_sql);

    // Check if results were found
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $type = $row['type'];
            $name = htmlspecialchars($row['name']);
            $details = $row['details'];

            // Display each result in a card format
            if ($type === 'Customer') {
                $search_results .= "
                <div class='col-md-4 mb-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'><i class='fas fa-user me-2' style='color: #007bff;'></i>Customer: $name</h5>
                            <p class='card-text'>Contact: " . htmlspecialchars($details) . "<br>Email: " . htmlspecialchars($row['email']) . "</p>
                        </div>
                    </div>
                </div>";
            } else {
                $search_results .= "
                <div class='col-md-4 mb-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'><i class='fas fa-box me-2' style='color: #28a745;'></i>Product: $name</h5>
                            <p class='card-text'>Price: $" . number_format((float)$details, 2) . "</p>
                        </div>
                    </div>
                </div>";
            }
        }
    } else {
        $search_results = "<p class='mt-4'>No results found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Icons -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Search Results</h2>
        <div class="row">
            <?php
            // Display search results or message
            if (isset($search_results)) {
                echo $search_results;
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
