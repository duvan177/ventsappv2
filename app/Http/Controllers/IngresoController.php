<?php

namespace App\Http\Controllers;

use App\ingreso;
use App\persona;
use App\articulo;
use App\base_dia;



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

        $ingresos = $this->prueba($ingreso);

        return response()->json($ingresos, 200);

    }
    public function setingresos(){
    

        $ingreso = ingreso::leftJoin('detalle_ingreso','ingreso.id','=','detalle_ingreso.idingreso')
        ->orderBy('ingreso.created_at', 'desc')
        ->whereNotIn('ingreso.idproveedor',[3])
        ->get();
  
        $ingresos = $this->prueba($ingreso);

        return response()->json($ingresos, 200);
    }
 
        public function setingresofecha(Request $request){
            $data = $request->all();
        
            $ingreso = ingreso::
            leftJoin('detalle_ingreso','ingreso.id','=','detalle_ingreso.idingreso')
            //  ->whereBetween('ingreso.created_at', [$data['inicio'], $data['fin']])
           ->whereDate('ingreso.created_at','=',$data['fecha'])
            ->orderBy('ingreso.created_at', 'desc')
            ->get();
     
            $ingresos = $this->prueba($ingreso);

            return response()->json($ingresos, 200);
        }

        public function setmesingreso(Request $request){
            
            $data = $request->all();
            $year = substr($data['mes'],0,4);
            $mes = substr($data['mes'],5,2);
            $ingreso = ingreso::
            leftJoin('detalle_ingreso','ingreso.id','=','detalle_ingreso.idingreso')
           ->whereYear('ingreso.created_at','=',$year)
           ->whereMonth('ingreso.created_at','=',$mes)
            ->orderBy('ingreso.created_at', 'desc')
            ->get();
            $ingresos = $this->prueba($ingreso);
            return response()->json($ingresos, 200);
        }
        
        public function prueba( $ingreso){

            $ingreso->map(function($ingreso){
                $articulo = articulo::find($ingreso->idarticulo);
               $ingreso->articulo = $articulo;
           });
    
           $ingreso->map(function($ingreso){
              $persona = persona::where('idpersona',$ingreso->idproveedor)->first();
              $ingreso->proveedor = $persona;
          });

          return json_decode($ingreso);
        }
        public function basedia(Request $request){
             $data = base_dia::all();
            return response()->json($data);
        }

    }
