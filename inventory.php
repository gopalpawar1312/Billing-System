<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <style>
        .table {
    margin-top: 30px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.table:hover {
    transform: scale(1.02);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

.table th {
    background-color: #007bff;
    text-transform: uppercase;
    color:#e9ecef;
    letter-spacing: 1px;
    font-weight: bold;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.table th:hover {
    background-color: #e9ecef;
    color: #343a40;
}

.table tbody tr {
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f1f3f5;
    transform: translateX(5px);
}

.btn-edit {
    color: #fff;
    background-color: #ffc107;
    border-color: #ffc107;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-edit:hover {
    background-color: #ffca2c;
    transform: translateY(-2px);
    box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15);
}

.btn-delete {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-delete:hover {
    background-color: #e02f3c;
    transform: translateY(-2px);
    box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15);
}

.modal-content {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal.fade .modal-dialog {
    transform: translateY(-30px);
    opacity: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal.fade.show .modal-dialog {
    transform: translateY(0);
    opacity: 1;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
    background-color: #0a58ca;
    transform: scale(1.05);
}

    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">View Products</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Brand</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db_connection.php';
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='product-row-" . $row["id"] . "'>
                        <td class='product-name'>" . $row["name"] . "</td>
                        <td class='product-price'>$" . number_format($row["price"], 2) . "</td>
                        <td class='product-quantity'>" . $row["quantity"] . "</td>
                        <td class='product-brand'>" . $row["brand"] . "</td>
                        <td>
                            <button class='btn btn-warning btn-sm btn-edit' data-id='" . $row["id"] . "' data-name='" . $row["name"] . "' data-price='" . $row["price"] . "' data-quantity='" . $row["quantity"] . "' data-brand='" . $row["brand"] . "' data-bs-toggle='modal' data-bs-target='#editModal'>
                                <i class='bi bi-pencil-square'></i> Edit
                            </button>
                            <a href='delete_product.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm btn-delete'>
                                <i class='bi bi-trash'></i> Delete
                            </a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="product-id">
                    <div class="form-group mb-3">
                        <label for="product-name">Product Name</label>
                        <input type="text" class="form-control" id="product-name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="product-price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="product-price" name="price" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="product-quantity">Quantity</label>
                        <input type="number" class="form-control" id="product-quantity" name="quantity" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="product-brand">Brand</label>
                        <input type="text" class="form-control" id="product-brand" name="brand" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const quantity = this.getAttribute('data-quantity');
            const brand = this.getAttribute('data-brand');

            document.getElementById('product-id').value = id;
            document.getElementById('product-name').value = name;
            document.getElementById('product-price').value = price;
            document.getElementById('product-quantity').value = quantity;
            document.getElementById('product-brand').value = brand;
        });
    });

    
    $("#editForm").on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: 'edit_product.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    
                    const id = $("#product-id").val();
                    $(`#product-row-${id} .product-name`).text($("#product-name").val());
                    $(`#product-row-${id} .product-price`).text(`$${parseFloat($("#product-price").val()).toFixed(2)}`);
                    $(`#product-row-${id} .product-quantity`).text($("#product-quantity").val());
                    $(`#product-row-${id} .product-brand`).text($("#product-brand").val());

                    // Close the modal
                    $("#editModal").modal('hide');
                } else {
                    alert('Error: ' + data.message);
                }
            },
            error: function() {
                alert('There was an error processing the request.');
            }
        });
    });
</script>
</body>
</html>
