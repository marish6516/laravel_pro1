<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
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
        <h2 class="mb-4">Category List</h2>
        <form id="cat_form" action="" method="get" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cat_name">Category Name</label>
                    <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="">
                    <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Enter Category name">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id = 'submit'>Add Category</button>
        </form>
        <table class="table table-striped" id = 'category_table'>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $table_tr; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#cat_id').val('0');
        $('#cat_form').on('submit', function(event) {
            event.preventDefault();
            var cat_name = $('#cat_name').val();
            var cat_id = $('#cat_id').val(); // HIDDEN CATEGORY ID
            if (cat_name === '') {
                toastr.error('Category name is required..');
                return false;
            }
            $.ajax({
                url: '/submit_category', // Replace with your API endpoint
                method: 'GET',
                data: { cat_name: cat_name,cat_id:cat_id },
                dataType : 'json',
                beforeSend: function() {
                    $('#submit').attr('disabled', 'disabled');
                    $('#submit').html('Processing... <i class="fas fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Category added successfully.');
                        $('#category_table tbody').html(response.table_tr); // REPLACE TABLE DATA
                    } else {
                        toastr.error(response.message);
                    }
                    $('#submit').removeAttr('disabled');
                    $('#submit').html('Add Category');
                    $('#cat_form')[0].reset();
                },
                error: function() {
                    toastr.error('An error occurred while adding the category.');
                }
            });
        });
    });

    // EDIT CATEGORY
    function edit_category(id){
        $.ajax({
            url: '/edit_category', // Replace with your API endpoint
            method: 'GET',
            data: { cat_id: id },
            dataType : 'json',
            beforeSend: function() {
                $('#edit_'+id).attr('disabled', 'disabled');
                $('#edit_'+id).html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                if (response.success) {
                    $('#cat_name').val(response.data.category_name);
                    $('#cat_id').val(response.data.fk_category_id);
                    $('#submit').html('Update Category');
                } else {
                    toastr.error(response.message);
                }
                $('#edit_'+id).removeAttr('disabled');
                $('#edit_'+id).html('Edit');
            },
            error: function() {
                toastr.error('An error occurred while fetching the category data.');
            }
        });
    }

    // DELETE CATEGORY
    function delete_category(id){
        if(confirm('Are you sure you want to delete this category?')){
            $.ajax({
                url: '/delete_category', // Replace with your API endpoint
                method: 'GET',
                data: { cat_id: id },
                dataType : 'json',
                beforeSend: function() {
                    $('#delete_'+id).attr('disabled', 'disabled');
                    $('#delete_'+id).html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#category_table tbody').html(response.table_tr);
                    } else {
                        toastr.error(response.message);
                    }
                    $('#delete_'+id).removeAttr('disabled');
                    $('#delete_'+id).html('Delete');
                },
                error: function() {
                    toastr.error('An error occurred while deleting the category.');
                }
            });
        }
    }
</script>
<style>
    .error{
        color: red;
    }
</style>