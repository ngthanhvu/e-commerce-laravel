<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['varriant_name', 'varriant_price', 'varriant_quantity', 'products_id', 'sku'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
