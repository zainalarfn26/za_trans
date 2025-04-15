<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'status',
        'rental_price',
        'description',
        'image'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
