<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingLike extends Model
{
    protected $fillable = ['user_id', 'rating_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }
}
