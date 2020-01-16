<?php

namespace App\Http\Controllers;

use App\ingreso;
use App\persona;
use App\articulo;

use Illuminate\Http\Request;

class IngresoController extends Controller
{

    public function createingreso( Request $request ){

        //  ingreso::create($request->all());

        return response()->json($request);

    }
    public function setingresos(){

        $ingreso = ingreso::leftJoin('detalle_ingreso','ingreso.id','=','detalle_ingreso.idingreso')
        ->orderBy('ingreso.created_at', 'desc')
        ->get();
        $ingreso->map(function($ingreso){
             $articulo = articulo::find($ingreso->idarticulo);
            $ingreso->articulo = $articulo;
        });

        $ingreso->map(function($ingreso){
           $persona = persona::where('idpersona',$ingreso->idproveedor)->first();
           $ingreso->proveedor = $persona;
       });
        $data = 'ingresos';
        return response()->json($ingreso, 200);
    }
 
}
