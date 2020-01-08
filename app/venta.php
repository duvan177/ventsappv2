<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    protected $table = 'venta';
    protected $fillable = [
       'idventa','idcliente','user_id','tipo_comprobante','serie_comprobante','num_comprobante',
       'impuesto','descuento','total_venta','estado'
    ];
}
