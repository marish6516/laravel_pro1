<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
route::get('/', [Controllers\Controller::class, 'index']);

// CATEGORY
route::get('/view_category', [Controllers\Controller::class, 'view_category']);
route::get('/submit_category', [Controllers\Controller::class, 'submit_category']);
route::get('/edit_category', [Controllers\Controller::class, 'edit_category']);
route::get('/delete_category', [Controllers\Controller::class, 'delete_category']);

// PRODUCT
route::get('/view_product', [Controllers\Controller::class, 'view_product']);
route::post('/submit_product', [Controllers\Controller::class, 'submit_product']);
route::get('/edit_product', [Controllers\Controller::class, 'edit_product']);
route::get('/delete_product', [Controllers\Controller::class, 'delete_product']);

// PRODUCT DETAILS
route::get('/product_details', [Controllers\Controller::class, 'product_details']);