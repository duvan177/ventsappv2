<?php

namespace App\Http\Controllers;

use App\venta;
use App\detalleventa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
   public function getventa(Request $request){
  
        $data = $request->all();
         $venta =  venta::create($data);
         
         foreach ($data['detalles'] as $key => $value) {
            $value['idventa']= $venta->id;
            detalleventa::create($value);
         }


       return response()->json();
   }

   public function getdetalleventa(Request $request){

    return response()->json('detalle venta');
       }
       

}
