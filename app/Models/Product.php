<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'product_name',
        'description',
        'price',
        'discount_rate',
        'stock_quantity',
    ];


    // Product.php (Model)
    // Product.php
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Product.php
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
