<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalleingreso extends Model
{
    protected $table = 'detalle_ingreso';
    protected $fillable = [
                'id','idingreso','idarticulo','cantidad','precio_compra', 'precio_venta'
      ];
}
