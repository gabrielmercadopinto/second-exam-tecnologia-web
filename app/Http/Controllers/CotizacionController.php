<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index(){
      return view('VCotizacion.index');
    }

    public function create(){
        return view('VCotizacion.create');
    }


    public function edit(Cotizacion $cotizacion){
        return view('VCotizacion.edit', compact('cotizacion'));
      }


}
