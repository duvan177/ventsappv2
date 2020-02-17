<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class base_dia extends Model
{
    protected $table = "base_dia";
    protected $fillable = [
        'id','basetotal'
       ];
}
