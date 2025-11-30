<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return compact('products');
    }

    public function byCategory($category){
        $category = Category::where('name',$category)->first();
        return response()->json(["products"=>$category->products]);
    }
}
