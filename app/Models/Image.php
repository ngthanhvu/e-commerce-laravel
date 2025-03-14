<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['sub_image', 'is_main', 'products_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
