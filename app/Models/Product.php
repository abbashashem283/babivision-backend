<?php

namespace App\Models;

use Attribute;
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

    public function attributes(){
        return $this->belongsToMany(Attribute::class)->withPivot('value','image')->withTimestamps();
    }
   
}
