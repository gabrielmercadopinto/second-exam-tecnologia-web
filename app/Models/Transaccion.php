<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;


    protected $fillable = [
        'transaccion',
        'fecha_generada',
        'fecha_pagada',
        'fecha_validez',
        'estado',
    ];

    //realcion con notra de venta, solo usar belong o hasmany
    public function notaventa()
    {
        return $this->hasMany(NotaVenta::class);
    }
}
