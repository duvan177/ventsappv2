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

         $numcomp = venta::max('num_comprobante');
         $data = ['msg'=>'registrado con exito','numero'=>$numcomp];
       return response()->json($data);
   }

   public function getdetalleventa(Request $request){
      $numcomp = venta::max('num_comprobante');
      if ($numcomp) {
         return response()->json($numcomp);
      }else {
         return response()->json('1001');
      }
   
       }
       

}
