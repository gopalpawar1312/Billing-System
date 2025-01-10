<?php include 'db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Billing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h1 {
            margin-bottom: 30px;
            color: #343a40;
        }
        .table {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-striped tbody tr:hover {
            background-color: #e2e6ea;
            transition: background-color 0.3s ease;
        }
        .btn {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .no-record {
            text-align: center;
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>View Billing</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT billing.id, customers.name AS customer_name, products.name AS product_name, billing.quantity, (billing.quantity * products.price) AS total_price
                    FROM billing
                    INNER JOIN customers ON billing.customer_id = customers.id
                    INNER JOIN products ON billing.product_id = products.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["customer_name"]) . "</td>
                        <td>" . htmlspecialchars($row["product_name"]) . "</td>
                        <td>" . htmlspecialchars($row["quantity"]) . "</td>
                        <td>$" . number_format($row["total_price"], 2) . "</td>
                        <td>
                            <a href='edit_billing.php?id=" . htmlspecialchars($row["id"]) . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>
                            <a href='delete_billing.php?id=" . htmlspecialchars($row["id"]) . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-record'>No billing records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
