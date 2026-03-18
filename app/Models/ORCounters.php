<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ORCounters extends Model
{
    protected $table = "or_counter";
    protected $fillable = [
        'or_count' , 'format_id'
    ];
}
