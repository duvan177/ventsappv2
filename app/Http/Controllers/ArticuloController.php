<?php

namespace App\Http\Controllers;

use App\articulo;
use App\categoria;
use App\ingreso_pan;
use App\baja_articulos;
use App\detalleingreso;


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

    public function setarticulosSin(){

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


    public function setarticulos()
    {
        $data = articulo::all();  
        $data->map(function($data){
            $maxid = detalleingreso::where('idarticulo',$data->id)->max('id');
        $precio_compra = detalleingreso::where('id',$maxid)->first();
       $data->precio_compra = $precio_compra;
        });
        
        return response()->json($data, 200);
    
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
        $art->stock =  $data['stock'];
        if ( $art->stock <= 10) {
          $data['estado'] = 2;
        }else {
           $data['estado'] = 1;
        }
        $art->update($data);

        return response()->json($art->estado);
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
    
    public function setpanaderia(){
        $data = articulo::where('idcategoria',5)->get();
        $data->map(function($data){
            $categoria = categoria::find($data->idcategoria);
           $data->categoria = $categoria;
       });
       return response()->json($data, 200);
        

    }
    public function savepan(Request $request){
        $data = $request->all();

        foreach ($data['data'] as $key => $value) {
           $articulo = articulo::find($value['id']);
           $stock = $articulo->stock + $value['cantidad'];
           $articulo->stock = $stock;
            $ingreso_pan = new ingreso_pan;
            $ingreso_pan->idarticulo = $value['id'];
            $ingreso_pan->cantidad = $value['cantidad'];
            $ingreso_pan->fecha = $value['fecha'];
            $ingreso_pan->save();
           $articulo->save();
           
        }
        return response()->json($data, 200);

    }
    public function updatepan(Request $request){
        $data = $request->all();
        $articulo = articulo::find($data['idpan']);
        $articulo->stock = $data['stock'];
        if ($articulo->stock <= 10) {
            $data['estado'] = 2;
        }else{
            $data['estado'] = 1;
        }
        $articulo->update($data);
        return response()->json('se actualizo', 200);
    }
    public function bajapan(Request $request){
        $data = $request->all();
        $articulo = articulo::find($data['id']);
        $stock = $articulo->stock - $data['cantidad'];
        $articulo->stock = $stock;
        $articulo->save();
        $totalperd = $articulo->precio_venta_art* $data['cantidad'];
        baja_articulos::create(['idarticulo'=>$articulo->id,'cantidad'=>$data['cantidad'],'total'=>$totalperd]);
        return response()->json('creado y actualizado');   
  
    }
    public function setbajaart(){
        $articulos = baja_articulos::orderBy('id', 'desc')->get();
        
        $articulos->map(function($articulos){
            $nombre = articulo::where('id',$articulos->idarticulo)->first();
           $articulos->nombre = $nombre['nombre'];
           $articulos->codigo = $nombre['codigo'];
          

       });
       return response()->json($articulos);
    }
    public function setingresopan(){
        $articulos = ingreso_pan::orderBy('id', 'desc')->get();
        
        $articulos->map(function($articulos){
            $nombre = articulo::where('id',$articulos->idarticulo)->first();
           $articulos->nombre = $nombre['nombre'];
           $articulos->codigo = $nombre['codigo'];
           $articulos->total = $nombre['precio_venta_art'];

        });
        return response()->json($articulos);
        
    }

    

}
