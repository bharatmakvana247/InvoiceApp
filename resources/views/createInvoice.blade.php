<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-5">
        <center>
            <h2>Invoice Form</h2>
        </center>
        <br>
        <form id="invoice-form">
            <!-- Customer Information -->
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name"
                    placeholder="Customer Name">
            </div>
            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email"
                    placeholder="Customer Email">
                <div id="error-messages" style="color: red"></div>
            </div>

            <!-- Product Information Section -->
            <h4>Products</h4>
            <div class="card p-3 mb-3">
                <div id="product-section">
                    <div class="product-item form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" name="product_name[]"
                                    placeholder="Product Name">
                            </div>
                            <div class="col-md-4">
                                <label for="product_price">Product Price</label>
                                <input type="number" class="form-control" name="product_price[]"
                                    placeholder="Product Price">
                            </div>
                            <div class="col-md-3">
                                <label for="product_discount">Discount (%)</label>
                                <input type="number" class="form-control" name="product_discount[]"
                                    placeholder="Discount">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-product">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-product" class="btn btn-secondary mt-3">Add Product</button>
            </div>
            <center>
                <a href="" class="btn btn-success">Total Items</a>
                <a href="" class="btn btn-success">Total Amounts</a>
                <a href="" class="btn btn-success">Total Discount Amounts</a>
                <a href="" class="btn btn-success">Total Bill</a>
            </center>
            <center>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </center>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            // Add new product row within the same card
            $('#add-product').click(function() {
                var productItem = `
                    <div class="product-item form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" name="product_name[]" placeholder="Product Name">
                            </div>
                            <div class="col-md-4">
                                <label for="product_price">Product Price</label>
                                <input type="number" class="form-control" name="product_price[]" placeholder="Product Price">
                            </div>
                            <div class="col-md-3">
                                <label for="product_discount">Discount (%)</label>
                                <input type="number" class="form-control" name="product_discount[]" placeholder="Discount">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-product">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#product-section').append(productItem);
            });

            // Remove product row
            $(document).on('click', '.remove-product', function() {
                $(this).closest('.product-item').remove();
            });

            // Basic email validation
            function validateEmail(email) {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

            $('#invoice-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Basic validation flags
                let isValid = true;

                // Validate customer name
                let customerName = $('#customer_name').val();
                if (customerName.trim() === '') {
                    isValid = false;
                    $('#customer_name').addClass('is-invalid');
                    $('#customer_name').after(
                        '<div class="invalid-feedback">Customer Name is required.</div>'
                    );
                }

                // Validate customer email
                let customerEmail = $('#customer_email').val();
                if (customerEmail.trim() === '') {
                    isValid = false;
                    $('#customer_email').addClass('is-invalid');
                    $('#customer_email').after(
                        '<div class="invalid-feedback">Customer Email is required.</div>'
                    );
                } else if (!validateEmail(customerEmail)) {
                    isValid = false;
                    $('#customer_email').addClass('is-invalid');
                    $('#customer_email').after(
                        '<div class="invalid-feedback">Invalid Email format.</div>'
                    );
                }

                // Validate product details
                let hasProductErrors = false;
                $('#product-section .product-item').each(function() {
                    let productName = $(this).find('input[name="product_name[]"]');
                    let productPrice = $(this).find('input[name="product_price[]"]');
                    let productDiscount = $(this).find('input[name="product_discount[]"]');

                    // Validate product name
                    if (productName.val().trim() === '') {
                        hasProductErrors = true;
                        productName.addClass('is-invalid');
                        productName.after(
                            '<div class="invalid-feedback">Product Name is required.</div>'
                        );
                    }

                    // Validate product price
                    if (productPrice.val().trim() === '' || isNaN(productPrice.val()) ||
                        productPrice.val() <= 0) {
                        hasProductErrors = true;
                        productPrice.addClass('is-invalid');
                        productPrice.after(
                            '<div class="invalid-feedback">Product Price is required and must be a positive number.</div>'
                        );
                    }

                    // Validate product discount
                    if (productDiscount.val().trim() === '' || isNaN(productDiscount.val()) ||
                        productDiscount.val() < 0) {
                        hasProductErrors = true;
                        productDiscount.addClass('is-invalid');
                        productDiscount.after(
                            '<div class="invalid-feedback">Product Discount is required and must be a non-negative number.</div>'
                        );
                    }
                });

                if (hasProductErrors) {
                    isValid = false;
                }

                // If form is invalid, stop the submission
                if (!isValid) {
                    return;
                }

                // Collect product details into an array of objects
                let products = [];
                $('#product-section .product-item').each(function() {
                    let productName = $(this).find('input[name="product_name[]"]').val();
                    let productPrice = $(this).find('input[name="product_price[]"]').val();
                    let productDiscount = $(this).find('input[name="product_discount[]"]').val();

                    products.push({
                        product_name: productName,
                        product_price: productPrice,
                        product_discount: productDiscount
                    });
                });

                const formData = {
                    customer_name: customerName,
                    customer_email: customerEmail,
                    products: products
                };

                $.ajax({
                    url: '{{ route('invoice.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log("Response: ", response);
                        $('#invoice-form')[0].reset(); // Reset form
                    },
                    error: function(response) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    let errorMessages = errors[key];
                                    let inputField = $(`[name="${key}"]`);
                                    inputField.addClass('is-invalid');
                                    inputField.after(
                                        `<div class="invalid-feedback">${errorMessages.join(', ')}</div>`
                                    );
                                }
                            }
                        } else {
                            alert('Error occurred. Please try again.');
                        }
                        // alert('Error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>
