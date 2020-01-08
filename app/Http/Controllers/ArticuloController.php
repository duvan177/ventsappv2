<?php

namespace App\Http\Controllers;

use App\articulo;
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
        $data = articulo::all();  
         
        return response()->json($data, 200);
    
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
}
