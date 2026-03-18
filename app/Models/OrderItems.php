<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItems extends Model
{
    protected $table = "order_items";

    protected $fillable = [
        'order_id','item_id','qty','price_per_item','total_price'
    ];

    /**
     * itemDetails
     *
     * @return HasOne
     */
    public function itemDetails(): HasOne
    {
        return $this->hasOne(Inventory::class,'id','order_id');
    }
}
