<?php

namespace Domain\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory, HasStates;

    protected $fillable = [
        'payment_gateway', 'method' , 'payload'
    ];

    protected $casts = [
        'payload' => 'collection',
    ];

}
