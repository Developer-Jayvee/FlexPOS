<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ORFormat extends Model
{
    protected $table = "or_format";
    protected $fillable = [
        'prefix' , 'has_date' , 'date_format' , 'number_length'
    ];

    protected function orNoFormat(): Attribute
    {
        return Attribute::make(
            get: function(int $value, array $attributes){
                $prefix = $attributes['prefix'];
                $numberLength = $attributes['number_length'];
                $date = $attributes['date_format'] ?  date($attributes['date_format']) : date('Y');
                $leadingZero = str_pad("",$numberLength,"0");
                $format = $prefix . $date . $leadingZero;
                $append = $value;
                if($numberLength >= strlen($append)){
                    return substr($format,0,(strlen($append) * (-1))). $append;
                }
                return  substr($format,0,($numberLength * (-1))). $append;
            }
        );
    }
}
