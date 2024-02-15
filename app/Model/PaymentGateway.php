<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;
     protected $table = 'seller_payment';

    protected $fillable = [
    'key_name', 'is_active', 'live_values', 'additional_data', 'gateway_title', 'gateway_image', 'mode', 'status', 'seller_id','api_secret','api_key'
    // Add other columns as needed
];

}
