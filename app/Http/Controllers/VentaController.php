<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        return view('VVenta.index');
    }

    public function create()
    {
        return view('VVenta.create');
    }
}
