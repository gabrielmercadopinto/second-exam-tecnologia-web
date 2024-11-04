<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarcaController extends Controller
{
    function index() {

        return view('VMarca.index');
    }
}
