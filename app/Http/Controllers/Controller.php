<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class Controller
{
    // Index Page Redirect
    public function index(){
        $product_details  = $this->create_index_product_table();
        $header           = $this->header();
        return view('index')->with(compact('product_details', 'header'));
    }

    // Create Category Page Redirect With Data 
    public function view_category(){
        $table_tr      = $this->create_cat_table();
        $header        = $this->header();
        return view('category')->with(compact('table_tr' , 'header'));
    }

    // Edit Category
    public function edit_category(){
        $cat_id = request('cat_id');
        $category_data = DB::table('fk_category')->where('fk_category_id', $cat_id)->first();
        return response()->json(['success' => true, 'data' => $category_data]);
    } 

    // Save Category
    public function submit_category(){
        $cat_id       = request('cat_id');
        $cat_name     = request('cat_name');
        $created_date = date('Y-m-d H:i:s');
        $status       = 1;
        if($cat_id == 0){
            DB::table('fk_category')->insert(['category_name' => $cat_name , 'created_date' => $created_date, 'status' => $status]);
            $message = 'Category added successfully.';
        }else{
            DB::table('fk_category')->where('fk_category_id', $cat_id)->update(['category_name' => $cat_name]);
            $message = 'Category updated successfully.';
        }
        $table_tr    = $this->create_cat_table();
        return response()->json(['success' => true, 'message' => $message , 'table_tr' => $table_tr]);
    }

    // Delete Category
    public function delete_category(){
        $cat_id   = request('cat_id');
        DB::table('fk_category')->where('fk_category_id', $cat_id)->update(['status' => 0]);
        $table_tr = $this->create_cat_table();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully.', 'table_tr' => $table_tr]);
    }

    // Create Category Table 
    public function create_cat_table(){
        $category_data  = DB::table('fk_category')->where('status',1)->get();
        $table_tr       = '';
        $i              = 1; 
        foreach($category_data as $value){
            $category_name = $value->category_name;  
            $table_tr .= '<tr>';
            $table_tr .= '<td>'.$i++.'</td>';
            $table_tr .= '<td>'.$category_name.'</td>';
            $table_tr .= '<td><button class="btn btn-warning btn-sm" id = "edit_'.$value->fk_category_id.'" onclick = "edit_category('.$value->fk_category_id.')">Edit</button><button class="btn btn-danger btn-sm" id = "delete_'.$value->fk_category_id.'" onclick
            = "delete_category('.$value->fk_category_id.')">Delete</button></td>';
            $table_tr .= '</tr>';
        }
        return $table_tr;
    }
    
    // Create Product Page Redirect With Data
    public function view_product(){
        $table_tr        = $this->create_product_table();
        $cat_drop        = DB::table('fk_category')->where('status',1)->get();
        $category_option = '';
        foreach($cat_drop as $value){
            $category_option .= '<option value="'.$value->fk_category_id.'">'.$value->category_name.'</option>';
        }
        $header          = $this->header();
        return view('products')->with(compact('table_tr' , 'category_option' , 'header'));
    }

    // Save Product
    public function submit_product(){
        $cat_id        = request('category_id');
        $product_id    = request('pro_id');
        $product_name  = request('product_name');
        $product_price = request('product_price');
        $product_brand = request('product_brand');
        $product_desc  = request('product_description');
        $product_image = request('product_image');
        if (request()->hasFile('product_image')) {
            $file      = request()->file('product_image');
            $path      = $file->store('products', 'public');
            $product_image = $path;
        }
        $created_date  = date('Y-m-d H:i:s');
        $status        = 1;
        if($product_id == 0){
            DB::table('fk_products')->insert(['category_id' => $cat_id,  'product_name' => $product_name , 'price' => $product_price ,'product_brand' => $product_brand ,'product_description' => $product_desc,'product_img_path'=> $product_image,'created_date' => $created_date, 'status' => $status]);
            $message = 'Product added successfully.';
        }else{
            DB::table('fk_products')->where('fk_product_id', $product_id)->update(['category_id' => $cat_id, 'product_name' => $product_name, 'price' => $product_price , 'product_brand' => $product_brand , 'product_description' => $product_desc , 'product_img_path' => $product_image]);
            $message = 'Product updated successfully.';
        }
        $table_tr     = $this->create_product_table();
        return response()->json(['success' => true, 'message' => $message, 'table_tr' => $table_tr]);
    }

    // Edit Product
    public function edit_product(){
        $product_id   = request('product_id');
        $product_data = DB::table('fk_products')->where('fk_product_id', $product_id)->first();
        $edit_data    = [];
        foreach($product_data as $key => $value){
            $edit_data[$key] = $value;
        }
        return response()->json(['success' => true, 'edit_data' => $edit_data]);
    }

    // Delete Product
    public function delete_product(){
        $product_id = request('product_id');
        DB::table('fk_products')->where('fk_product_id', $product_id)->update(['status' => 0]);
        $table_tr   = $this->create_product_table();
        return response()->json(['success' => true, 'message' => 'Product deleted successfully.', 'table_tr' => $table_tr]);
    }

    // Create Product Table
    public function create_product_table(){
        $product_data = DB::table('fk_products')
            ->join('fk_category', 'fk_products.category_id', '=', 'fk_category.fk_category_id')
            ->select('fk_products.*', 'fk_category.category_name')
            ->where('fk_products.status', 1)
            ->get();
        $table_tr     = '';
        $i            = 1; 
        foreach($product_data as $value){
            $product_name  = $value->product_name;
            $category      = $value->category_name;
            $product_price = $value->price;
            $table_tr     .= '<tr>';
            $table_tr     .= '<td>'.$i++.'</td>';
            $table_tr     .= '<td>'.$category.'</td>';
            $table_tr     .= '<td>'.$product_name.'</td>';
            $table_tr     .= '<td>'.$product_price.'</td>';
            $table_tr     .= '<td><button class="btn btn-warning btn-sm" id = "edit_'.$value->fk_product_id.'" onclick = "edit_product('.$value->fk_product_id.')">Edit</button><button class="btn btn-danger btn-sm" id = "delete_'.$value->fk_product_id.'" onclick = "delete_product('.$value->fk_product_id.')">Delete</button></td>';
            $table_tr .= '</tr>';
        }
        return $table_tr;
    } 

    // Create Index Product Table
    public function create_index_product_table(){
        $productDetails = DB::table('fk_products')
            ->join('fk_category', 'fk_products.category_id', '=', 'fk_category.fk_category_id')
            ->select('fk_products.*', 'fk_category.category_name')->where('fk_products.status', 1)
            ->get();
        $table_tr          = '';
        $i                 = 1; 
        $t_div             = '';
        $table_tr         .= '<tbody><tr>';
        foreach($productDetails as $value){
            $product_id    = $value->fk_product_id;
            $product_name  = $value->product_name;
            $category      = $value->category_name;
            $product_price = $value->price;
            $img_path      = asset("storage/$value->product_img_path");
            $t_div        .= '<div class="col-md" onclick="product_details('.$product_id.')">';
            $t_div        .= '<div class="">';
            $t_div        .= '<div class="card-body">';
            $t_div        .= '<h5 class="card-title">'.$product_name.'</h5>';
            $t_div        .= '<img src='.$img_path.' class="card-img-top" alt="'.$product_name.'" style="height: 120px;width: 115px;"/>';
            $t_div        .= '<p class="card-text">'.$category.'</p>';
            $t_div        .= '<p class="card-text">'.$product_price.'$</p>';
            $t_div        .= '<p class="card-text" style="word-wrap:break-word;width: 139px;">'.$value->product_description.'</p>';
            $t_div        .= '<a href="#" class="btn btn-primary">Add to Cart</a>';
            $t_div        .= '</div>';
            $t_div        .= '</div>';
            $t_div        .= '</div>';
            $table_tr     .= '<td>'.$t_div.'</td>';
            $t_div         = '';
            if($i % 6 == 0){
                $table_tr .= '</tr>';
                $table_tr .= '<tr>';
            }
            $i++;
        }
        $table_tr .= '</tbody></tr>';
        return $table_tr;
    }
    

    // Product Details Page Redirect
    public function product_details(){
        $product_id   = request('product_id');
        $product_data = DB::table('fk_products')->where('fk_product_id', $product_id)->first();
        $header       = $this->header();
        return view('product_details')->with(compact('product_data', 'header'));
    }
    
    // Common Header
    public function header(){
        $header = '<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">
                <img src="'.asset('storage/icon.png').'" alt="Flipkart" class="d-inline-block align-top" style="height: 33px;"/>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="form-inline my-2 my-lg-0 ml-auto">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search for Brands ,Products  and More" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="\">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="\">
                            <i class="fas fa-home"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="\view_category">
                            <i class="fas fa-th-list"></i>
                            Category
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="\view_product">
                            <i class="fas fa-box-open"></i>
                            Product
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-cart"></i>
                            Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Become a Seller</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-secondary">
                            <span class="dots-icon">⋮</span>
                        </button>
                    </li>
                </ul>
            </div>
        </nav>';
        return $header; 
    }
}
