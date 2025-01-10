<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $brand = $_POST['brand'];

    $sql = "UPDATE products SET name = ?, price = ?, quantity = ?, brand = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdisi', $name, $price, $quantity, $brand, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update product']);
    }

    $stmt->close();
    $conn->close();
}
?>
