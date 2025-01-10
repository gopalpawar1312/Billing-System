<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer'];
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO billing (customer_id, product_id, quantity) VALUES ('$customer_id', '$product_id', '$quantity')";
    if ($conn->query($sql) === TRUE) {
        $success = "Billing information added successfully!";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Billing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .alert {
            margin-top: 15px;
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="mb-4 text-center">Add Billing</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> <?= $success ?>
        </div>
    <?php elseif (!empty($error)): ?>
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group mb-3">
            <label>Select Customer</label>
            <select class="form-control" name="customer" required>
                <?php
                $sql = "SELECT * FROM customers";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Select Product</label>
            <select class="form-control" name="product" required>
                <?php
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Quantity</label>
            <input type="number" class="form-control" name="quantity" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-2">Save Billing</button>
    </form>
    <a href="view_billing.php" class="btn btn-secondary w-100">View Billing</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
