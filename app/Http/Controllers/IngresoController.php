<?php

namespace App\Http\Controllers;

use App\ingreso;
use App\persona;
use Illuminate\Http\Request;

class IngresoController extends Controller
{

    public function createingreso( Request $request ){

         ingreso::create($request->all());

        return response()->json('creado');

    }
 
}
