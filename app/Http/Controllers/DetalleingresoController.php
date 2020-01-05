<?php

namespace App\Http\Controllers;

use App\detalleingreso;
use Illuminate\Http\Request;

class DetalleingresoController extends Controller
{
   public function registrodetalle(Request $request){

    $data = $request->all();
        
foreach ($data['arraydata'] as $key => $value) {
    detalleingreso::create($data['arraydata'][$key]);

}
        
    return response()->json('registro completo');
    }
}
