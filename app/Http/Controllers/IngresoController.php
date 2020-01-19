<?php

namespace App\Http\Controllers;

use App\ingreso;
use App\persona;
use App\articulo;

use Illuminate\Http\Request;

class IngresoController extends Controller
{

    public function busquedaingreso( Request $request ){
        $data = $request->all();
        
        $ingreso = ingreso::
        leftJoin('detalle_ingreso','ingreso.id','=','detalle_ingreso.idingreso')
        //  ->whereBetween('ingreso.created_at', [$data['inicio'], $data['fin']])
       ->whereDate('ingreso.created_at','>=',$data['inicio'])
       ->whereDate('ingreso.created_at','<=',$data['fin'])
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
        

        return response()->json($ingreso);

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
 
        public function setingresofecha(Request $request){
            $data = $request->all();
        
            $ingreso = ingreso::
            leftJoin('detalle_ingreso','ingreso.id','=','detalle_ingreso.idingreso')
            //  ->whereBetween('ingreso.created_at', [$data['inicio'], $data['fin']])
           ->whereDate('ingreso.created_at','=',$data['fecha'])
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
          return response()->json($ingreso, 200);
        }
}
