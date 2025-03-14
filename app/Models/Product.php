<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity', 'slug', 'category_id'];

    // Một sản phẩm thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Một sản phẩm có nhiều ảnh
    public function images()
    {
        return $this->hasMany(Image::class, 'products_id');
    }

    // Một sản phẩm có một ảnh chính (is_main = true)
    public function mainImage()
    {
        return $this->hasOne(Image::class, 'products_id')->where('is_main', true);
    }

    // Một sản phẩm có nhiều biến thể (variants)
    public function variants()
    {
        return $this->hasMany(Variant::class, 'products_id');
    }
}
