<?php

namespace App\Http\Controllers;
require __DIR__ . '/ticket/autoload.php';
use App\venta;
use App\detalleventa;

use App\detalleingreso;
use App\User;
use App\articulo;
use App\persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Carbon\Carbon;

class VentaController extends Controller
{
   public function getventa(Request $request){
      
      $nombre_impresora = "POS-58";

      $data = $request->all();
        $venta =  venta::create($data);
         $nombre = User::where('id',$data['user_id'])->first();
$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);
try {
     $logo = EscposImage::load("img/pan.png", false);
     $printer->bitImage($logo);
} catch (Exception $e) { }

$printer->text("TUTIPANDEBONO" . "\n");
$printer->text("NIT: 123123" . "\n");
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->text("user: ".$nombre->name. "\n");
   
$printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("- - - - - - - - - - - - - - - -" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Descripcion         Uds    Total" . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("- - - - - - - - - - - - - - - -" . "\n");
         
         

      
      foreach ($data['detalles'] as $key => $value) {
            $value['idventa']= $venta->id;
            detalleventa::create($value);
             $total =  (int)$value['precio_venta'] *  (int)$value['cantidad'];
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($value['nombre']."\n");        
             $line = sprintf('%-10.10s %10.0f %9.2f', 'cod'.$value['codigo'],$value['cantidad'],$total);
             $printer->text($line);
             $printer->text("\n");
            
          }
             $printer->setJustification(Printer::JUSTIFY_RIGHT);
             $printer->text("" . "\n");
             $printer->text(' descuento:........ $' . number_format($data['descuento']) . "\n");
                $printer->text(' TOTAL ........$'. number_format($data['total_venta']) . "\n");
          $printer->text("" . "\n");
          $printer->text("" . "\n");
          $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("..:Esperamos pronto tu visita:.." . "\n");
                $printer->text("....:Gracias por tu compra:....  " . "\n");
                $printer->text("" . "\n");
                $printer->text("" . "\n");
$printer->feed();

$printer->cut();

$printer->pulse();

$printer->close();

$numcomp = venta::max('num_comprobante');
          $resp = ['msg'=>'registrado con exito','numero'=>$numcomp];
     return response()->json($resp);
  
      //   $data = $request->all();
      //    $venta =  venta::create($data);
         
      //    foreach ($data['detalles'] as $key => $value) {
      //       $value['idventa']= $venta->id;
      //       detalleventa::create($value);
      //    }

       
   }

   public function getdetalleventa(Request $request){
      $numcomp = venta::max('num_comprobante');
      if ($numcomp) {
         return response()->json($numcomp);
      }else {
         return response()->json('1001');
      }
   
       }

      public function sendventas(){
         $ventas = venta::join('detalle_venta','detalle_venta.idventa','=','venta.id')
         ->select('detalle_venta.id','detalle_venta.idarticulo','detalle_venta.cantidad','detalle_venta.cantidad','detalle_venta.precio_venta',
         'detalle_venta.descuento','detalle_venta.created_at','venta.idcliente','venta.user_id','venta.tipo_comprobante','venta.serie_comprobante','venta.num_comprobante',
         'venta.impuesto','venta.descuento','venta.total_venta','venta.estado','venta.updated_at')
         ->orderBy('detalle_venta.created_at', 'desc')
         ->get();

        $newventas = $this->subconsultas($ventas);
     
         
         return response()->json($newventas);

       }

       public function subconsultas($ventas){
         $ventas->map(function($ventas){
            $articulo = articulo::find($ventas->idarticulo);
           $ventas->articulo = $articulo;
       });

       $ventas->map(function($ventas){
            $usuario = User::find($ventas->user_id);
           $ventas->usuario = $usuario;
       });
       $ventas->map(function($ventas){
            $cliente = persona::where('idpersona',$ventas->idcliente)->first();
           $ventas->cliente = $cliente;
       });
       $ventas->map(function($ventas){
        $maxid = detalleingreso::where('idarticulo',$ventas->articulo->id)->max('id');
        $precio_compra = detalleingreso::where('id',$maxid)->first();
       $ventas->precio_compra = $precio_compra;
   });
   return $ventas;
       }

   
       

}
