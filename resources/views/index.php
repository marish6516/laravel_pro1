<?php #echo "<pre>";print_r($productDetails);die;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flipkart Clone</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php echo $header;?>
    <div class="container mt-4" style="max-width: 1315px;padding: 10px;">
        <div class="row" style="border:2px #f3f3f3 solid; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="col">
                <div class="categories-nav d-flex justify-content-between">
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/kilo.webp')?>" alt="Kilos" />
                        <p>Kilos</p>
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/mobiles.webp')?>" alt="Mobiles" />
                        <p>Mobiles</p>
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/fashion.jpg')?>" alt="Fashion" style="height: 43px;"/>
                        <p>Fashion</p>
                        
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/electronics.jpg')?>" alt="Electronics" style="height: 43px;"/>
                        <p>Electronics</p>
                        
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/furniture.jpg')?>" alt="Home & Furniture" style="height: 43px;"/>
                        <p>Home & Furniture</p>
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/appliances.webp')?>" alt="Appliances" />
                        <p>Appliances</p>
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/flight.webp')?>" alt="Flight Bookings" />
                        <p>Flight Bookings</p>
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/toys.jpg')?>" alt="Beauty, Toys & More" style="height: 43px;"/>
                        <p>Beauty, Toys & More</p>
                        
                    </div>
                    <div class="category-item text-center p-2  bg-white rounded">
                        <img src="<?php echo asset('storage/logo/two_wheelers.jpg')?>" alt="Two Wheelers" style="height: 43px;"/>
                        <p>Two Wheelers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="max-width: 1315px;">
        <!-- Budget Products Section -->
        <section class="products-section my-4">
            <h2 class="section-title">499 only</h2>
            <div class="table-responsive" style="border: 2px #fffcfc solid; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <table class="">
                    <?php echo $product_details;?>
                </table>
            </div>
        </section>
    </div>
</body>
</html>

<script>
    $(document).ready(function() {
       
    });

    function product_details(id){
        window.location.href = '/product_details?product_id='+id;
    }
</script>