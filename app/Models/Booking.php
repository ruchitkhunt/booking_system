<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_name', 'customer_email', 'booking_date',
        'booking_type', 'booking_slot', 'booking_from', 'booking_to'
    ];
}
