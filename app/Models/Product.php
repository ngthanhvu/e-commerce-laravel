<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'original_price', 'discount_price', 'quantity', 'slug', 'category_id', 'count', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'products_id');
    }

    public function mainImage()
    {
        return $this->hasOne(Image::class, 'products_id')->where('is_main', true);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'products_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
