<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SellerBanner extends Model
{
    
    protected $table ="seller_banners";
    protected $casts = [
        'published'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'resource_id' => 'integer',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'resource_id');
    }

}
