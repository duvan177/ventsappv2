<?php

namespace App\Http\Controllers;

use App\articulo;
use App\categoria;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{   

    public function articulos()
    {
        $data = articulo::join('detalle_ingreso','articulo.id','=','detalle_ingreso.idarticulo')
        ->select('articulo.codigo') 
        ->where('articulo.artdelete','=',1) 
        ->distinct()->get();
    
        $codigos = [];
        $consulta =[];
        foreach ($data as $key => $value) {
            array_push($codigos,$data[$key]['codigo']);
        }
        $dat =  array_unique($codigos);
        foreach ($codigos as $key => $value) {
            $datos = articulo::join('detalle_ingreso','articulo.id','=','detalle_ingreso.idarticulo')
            ->select('articulo.*','detalle_ingreso.precio_compra','detalle_ingreso.precio_venta') 
            ->where('articulo.artdelete','=',1)
            ->where('articulo.codigo',$value)
            ->orderBy('detalle_ingreso.id', 'desc')
            ->first();
            array_push($consulta,$datos);
        }

        
        return response()->json($consulta, 200);
        
        }


    public function setarticulos()
    {
        $data = articulo::select('codigo')->where('artdelete','=',1)->get();  
         
        $consulta = [];

        foreach ($data as $key => $value) {
            $datos = articulo::join('detalle_ingreso','articulo.id','=','detalle_ingreso.idarticulo')
            ->select('articulo.*') 
            // ->where('articulo.artelete','=',1)
            ->where('articulo.codigo',$value['codigo'])
            ->orderBy('detalle_ingreso.id', 'desc')
            ->first();
           if($datos == null){
            array_push($consulta,$value['codigo']);
           }
        $sendart=[];
           foreach ($consulta as $key => $value) {
             $art = articulo::where('codigo',$value)->first();
             array_push($sendart,$art);
           }

           
        }

        return response()->json($sendart, 200);
    
        }

    public function storearticulo(Request $request){
        $data = $request->all();
       if (articulo::create($data)){
           return response()->json('resgistrado');
       }else{
        return response()->json('error al registrar');
       }
    }
 

    public function actualizar(Request $request)
    {
        
        $data = $request->all();
        $art = articulo::find($data['id']);
        $art->update($data);
        return response()->json($data['id']);
    }

    public function artdelete(Request $request)
    {
       $data = $request->all();
        $art = articulo::find($data['id']);
        $art->update($data);
        return response()->json($data['id']);
    }

    public function setcategorias(){
        $data = categoria::all();
        return response()->json($data, 200);
    }   

    

}
