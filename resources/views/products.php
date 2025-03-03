<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <title>Products</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
</head>
<body>
    <?php echo $header;?>
    <div class="container mt-5">
        <h2 class="mb-4">Product List</h2>
        <form class="mb-4" id="pro_form" enctype="multipart/form-data">
            <input type="hidden" class="form-control" id="pro_id" name="pro_id" value="">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <option value="">Select Category</option>
                        <?php echo $category_option; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="product_brand">Product Brand</label>
                    <input type="text" class="form-control" id="product_brand" name="product_brand" placeholder="Enter product brand">
                </div>
                <div class="form-group col-md-4">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name">
                </div>
                <div class="form-group col-md-4">
                    <label for="product_price">Product Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter product price">
                </div>
                <div class="form-group col-md-4">
                    <label for="product_description">Product Description</label>
                    <textarea class="form-control" id="product_description" name="product_description" placeholder="Enter product description"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="product_image">Product Image</label>
                    <input type="file" class="form-control" id="product_image" name="product_image">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id='submit'>Add Product</button>
        </form>
        <table class="table table-striped" id = 'product_table'>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Category</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
               <?php echo $table_tr?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#pro_id').val('0');   
        $.validator.addMethod("checkPrice", function(value, element) {
            return this.optional(element) || /^\d+(\.\d{1,2})?$/.test(value);
        }, "*Please enter a valid price.");
        $('#pro_form').validate({
            rules: {
                category_id: {
                    required: true
                },
                product_name: {
                    required: true
                },
                product_price: {
                    required: true,
                    checkPrice: true
                },
                product_brand: {
                    required: true
                },
                product_description: {
                    required: true
                },
                product_image: {
                    required: true
                }
            },
            messages: {
                category_id: {
                    required: "*Please select a category."
                },
                product_name: {
                    required: "*Please enter the product name."
                },
                product_price: {
                    required: "*Please enter the product price.",
                    checkPrice: "*Please enter a valid price."
                },
                product_brand: {
                    required: "*Please enter the product brand."
                },
                product_description: {
                    required: "*Please enter the product description."
                },
                product_image: {
                    required: "*Please upload a product image."
                }
            },
            submitHandler: function(form) {
                event.preventDefault();
                var form_data = new FormData(form);
                form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: '/submit_product', // Replace with your API endpoint
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    dataType : 'json',
                    beforeSend: function() {
                        $('#submit').attr('disabled', 'disabled');
                        $('#submit').html('Processing... <i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        $('#submit').removeAttr('disabled');
                        $('#submit').html('Add Product');
                        if (response.success) {
                            toastr.success(response.message);
                            $('#product_name').val('');
                            $('#product_price').val('');
                            $('#product_table tbody').html(response.table_tr);
                        } else {
                            toastr.error(response.message);
                        }
                        $('#pro_form')[0].reset();
                    },
                    error: function() {
                        $('#submit').removeAttr('disabled');
                        $('#submit').html('Add Product');
                        toastr.error('Something went wrong..');
                    }
                });
            }
        });
    });

    // EDIT PRODUCT
    function edit_product(id){
        $.ajax({
            url: '/edit_product', // Replace with your API endpoint
            method: 'GET',
            data: { product_id: id },
            dataType : 'json',
            beforeSend: function() {
                $('#edit_'+id).attr('disabled', 'disabled');
                $('#edit_'+id).html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                response = response.edit_data;
                $('#category_id').val(response.category_id);
                $('#product_name').val(response.product_name);
                $('#product_price').val(response.price);
                $('#product_brand').val(response.product_brand);
                $('#product_description').val(response.product_description);
                // $('#product_image').val(response.product_img_path);
                $('#pro_id').val(id);
                $('#edit_'+id).removeAttr('disabled');
                $('#edit_'+id).html('Edit');
            },
            error: function() {
                toastr.error('An error occurred while editing the product.');
            }
        });
    }

    // DELETE PRODUCT
    function delete_product(id){
        $.ajax({
            url: '/delete_product', // Replace with your API endpoint
            method: 'GET',
            data: { product_id: id },
            dataType : 'json',
            beforeSend: function() {
                $('#delete_'+id).attr('disabled', 'disabled');
                $('#delete_'+id).html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Product deleted successfully.');
                    $('#product_table tbody').html(response.table_tr);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('An error occurred while deleting the product.');
            }
        });
    }
</script>
<style>
    .error{
        color: red;
    }
</style>