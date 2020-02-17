<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class baja_articulos extends Model
{
    protected $table = 'baja_articulos';
    protected $fillable = [
       'id','idarticulo','cantidad','total'
      ];
      protected $primaryKey = 'id';
}
