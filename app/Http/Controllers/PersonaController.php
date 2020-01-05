<?php

namespace App\Http\Controllers;

use App\persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
   public function personas(){
       $data = persona::all();
       return response()->json($data, 200);
   }
}
