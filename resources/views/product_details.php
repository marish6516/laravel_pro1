<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>  
</head>
<body>
    <?php #echo "<pre>";print_r($product_data);die;
    echo $header;?>
    <div class="container py-4">
        <div class="row">
            <!-- Product Images Section -->
            <div class="col-md-6 position-relative">
                <div class="wishlist-btn">
                    <i class="far fa-heart"></i>
                </div>
                
                <div class="row">
                    <div class="col-10">
                        <img src="<?php echo asset("storage/$product_data->product_img_path")?>" class="img-fluid mx-auto d-block" alt="Product Image">
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex mt-3">
                    <button class="btn btn-warning flex-grow-1">
                        <i class="fas fa-shopping-cart me-2"></i> ADD TO CART
                    </button>
                    <button class="btn btn-danger flex-grow-1">
                        <i class="fas fa-bolt me-2"></i> BUY NOW
                    </button>
                </div>
            </div>
            
            <!-- Product Details Section -->
            <div class="col-md-6">
                <div class="mb-2">
                    <h6 class="text-muted mb-1"><?php echo $product_data->product_name?></h6>
                    <h4 class="mb-2"><?php echo $product_data->product_description?></h4>
                    <p class="special-price mb-1">Special price</p>
                    
                    <div class="d-flex align-items-center mb-2">
                        <h3 class="me-2 mb-0">$<?php echo $product_data->price?></h3>
                        <span class="original-price me-2"> $1,199</span>
                        <span class="discount">69% off</span>
                        <i class="fas fa-info-circle ms-2 text-muted"></i>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating-container me-2">3.8 ★</div>
                        <span class="text-muted">939 ratings and 27 reviews</span>
                    </div>
                </div>
                
                <!-- Color Options -->
                <div class="mb-4">
                    <h6>Color</h6>
                    <div>
                        <a href="#" class="text-primary ms-2">+4 more</a>
                    </div>
                </div>
                
                <!-- Size Options -->
                <div class="mb-4">
                    <h6>Size</h6>
                    <div class="d-flex">
                        <div class="size-option border p-3 me-2">S</div>
                        <div class="size-option border p-3 me-2">M</div>
                        <div class="size-option border p-3 me-2">L</div>
                        <div class="size-option border p-3 me-2 active">XL</div>
                        <div class="size-option border p-3 me-2">XXL</div>
                    </div>
                </div>
                
                <!-- Available Offers -->
                <div class="mb-4">
                    <h6>Available offers</h6>
                    <div class="offer-item">
                        <i class="fas fa-tag offer-icon me-2"></i>
                        <strong>Bank Offer</strong> 5% Unlimited Cashback on Flipkart Axis Bank Credit Card
                        <a href="#" class="text-primary ms-1">T&C</a>
                    </div>
                    <div class="offer-item">
                        <i class="fas fa-tag offer-icon me-2"></i>
                        <strong>Bank Offer</strong> 10% off up to ₹1,250 on PNB Credit Card Transactions, on orders of ₹5,000 and above
                        <a href="#" class="text-primary ms-1">T&C</a>
                    </div>
                    <div class="offer-item">
                        <i class="fas fa-tag offer-icon me-2"></i>
                        <strong>Bank Offer</strong> 10% off on BOBCARD EMI Transactions, up to ₹1,500 on orders of ₹5,000 and above
                        <a href="#" class="text-primary ms-1">T&C</a>
                    </div>
                    <div class="offer-item">
                        <i class="fas fa-tag offer-icon me-2"></i>
                        <strong>Special Price</strong> Get extra 18% off (price inclusive of cashback/coupon)
                        <a href="#" class="text-primary ms-1">T&C</a>
                    </div>
                    <a href="#" class="text-primary">+4 more offers</a>
                </div>
                
                <!-- Delivery Options -->
                <div class="row">
                    <div class="col-md-6">
                        <h6>Deliver to</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter delivery pincode">
                            <button class="btn btn-outline-secondary" type="button">Check</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Services</h6>
                        <div>
                            <i class="fas fa-money-bill-wave text-primary me-2"></i>
                            Cash on Delivery available
                            <i class="fas fa-question-circle ms-2 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<style>
    .error{
        color: red;
    }
    .offer-icon{
        color: #388e3c;
    }
</style>