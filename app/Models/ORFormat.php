<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ORFormat extends Model
{
    protected $table = "or_format";
    protected $fillable = [
        'prefix' , 'has_date' , 'date_format' , 'number_length'
    ];
}
