<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = "payments";
    protected $fillable = [
        'ORNo','order_id','gross_price','tax','discount_id','grand_total'
    ];
}
