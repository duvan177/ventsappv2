<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ingreso extends Model
{
    protected $table = 'ingreso';
    protected $fillable = [
      'id','idproveedor','tipo_comprobante','serie_comprobante',
      'num_comprobante','impuesto','estado'
    ];
    protected $append = [ 'first_name' ];


    public function getFirstNameAttribute($value)
    {
      $this->attributes['first_name'] = strtolower($value);
    }
}
