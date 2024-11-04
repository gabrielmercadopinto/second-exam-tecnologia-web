<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_oem',
        'nombre',
        'precio',
        'unidad',
        'clasificacion_abc',
        'ubicacion',
        'stock',
        'stock_minimo',
        'estado',
        'marca_id',
        'categoria_id'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function detalle_venta()
    {
        return $this->hasMany(DetalleVenta::class);
    }


    public function detalle_compra()
    {
        return $this->hasMany(DetalleVenta::class);
    }


    public function detalle_cotizacion()
    {
        return $this->hasMany(DetalleCotizacion::class);
    }
}
