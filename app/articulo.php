<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class articulo extends Model
{
    protected $table = 'articulo';
  
    protected $fillable = [
        'id', 'idcategoria', 'codigo','nombre','stock','descripcion','estado','artdelete','precio_venta_art'
    ];
}
