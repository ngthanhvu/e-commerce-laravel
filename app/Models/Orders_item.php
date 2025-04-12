<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders_item extends Model
{
    use HasFactory;

    protected $table = 'orders_item';

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    public function mainImage()
    {
        return $this->hasOne(Image::class, 'product_id', 'product_id')->where('is_main', 1);
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'product_id')->where('is_main', 0);
    }
}
