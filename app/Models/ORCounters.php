<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ORCounters extends Model
{
    protected $table = "or_counter";
    protected $fillable = [
        'or_count' , 'format_id'
    ];

    public function orFormat():HasOne
    {
        return $this->hasOne(ORFormat::class,'id','format_id');
    }
}
