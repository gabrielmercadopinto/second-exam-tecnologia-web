<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    function index() {
        return view('VProducto.index');
    }

    function marca_index() {
        // dd('marca_index');
        return view('VMarca.index');
    }
}
