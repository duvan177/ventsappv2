<?php

namespace App\Http\Controllers;

use App\detalleingreso;
use App\ingreso;
use App\articulo;
use Illuminate\Http\Request;

class DetalleingresoController extends Controller
{
   public function registrodetalle(Request $request){

    $data = $request->all();
   $ingreso =  ingreso::create($request->all()); 

foreach ($data['arraydata'] as $key => $value) {

        $data['arraydata'][$key]['idingreso'] = $ingreso['id'];
      detalleingreso::create($data['arraydata'][$key]);
        $articulo = articulo::where('id',$data['arraydata'][$key]['idarticulo'])->update(['precio_venta_art' =>$data['arraydata'][$key]['precio_venta']]);

}

    return response()->json($data);
    }
}
