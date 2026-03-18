<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table ="orders";

    protected $fillable = [
        'ORNo','customer_name','total_qty','grand_total','process_by'
    ];
}
