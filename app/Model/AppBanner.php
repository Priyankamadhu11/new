<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppBanner extends Model
{
    
    protected $table ="app_banners";
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
