<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalleventa extends Model
{
    protected  $table = 'detalle_venta';

    protected $fillable = [
      'id','idventa','idarticulo','cantidad','precio_venta','descuento'
     ];
}
