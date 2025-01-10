<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $quantity = $_POST['product_quantity'];
    $brand = $_POST['product_brand'];
    $supplier = $_POST['product_supplier'];
    $old_stock = $_POST['old_stock'];
    $category = $_POST['product_category'];

    $sql = "INSERT INTO products (name, price, quantity, brand, supplier, old_stock, category) VALUES ('$name', '$price', '$quantity', '$brand', '$supplier', '$old_stock', '$category')";
    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
     
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
            letter-spacing: 2px;
            animation: slideIn 1s ease-out;
        }

        .form-group label {
            font-weight: 600;
            letter-spacing: 1px;
        }

        .form-control {
            border-radius: 3px;
            padding: 10px;
            transition: all 0.3s ease;
            border: 1px solid #007bff;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        /* Button styling with hover effects */
        .btn-primary {
            width: 100%;
            border-radius: 30px;
            background-color: #007bff;
            border: none;
            padding: 12px;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Transitions */
        .form-control {
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            transform: scale(1.05);
        }

    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Add Product</h1>
    <form action="add_product.php" method="post">
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" class="form-control" name="product_price" required>
        </div>
        <div class="form-group">
            <label>Product Quantity</label>
            <input type="number" class="form-control" name="product_quantity" required>
        </div>
        <div class="form-group">
            <label>Product Brand</label>
            <input type="text" class="form-control" name="product_brand" required>
        </div>
        <div class="form-group">
            <label>Product Supplier</label>
            <input type="text" class="form-control" name="product_supplier" required>
        </div>
        <div class="form-group">
            <label>Old Stock</label>
            <input type="number" class="form-control" name="old_stock" required>
        </div>
        <div class="form-group">
            <label>Product Category</label>
            <input type="text" class="form-control" name="product_category" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

</body>
</html>
