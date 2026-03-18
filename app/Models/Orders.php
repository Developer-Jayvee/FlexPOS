<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    protected $table ="orders";

    protected $fillable = [
        'ORNo','customer_name','total_qty','grand_total','process_by'
    ];
    
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class,'id','order_id');
    }
}
