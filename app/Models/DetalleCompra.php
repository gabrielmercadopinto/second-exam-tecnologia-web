<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota_compra_id',
        'producto_id',
        'cantidad',
        'precio',
    ];

    public function producto()
    {
        return $this->hasMany(Producto::class);
    }

    public function nota_compra()
    {
        return $this->hasMany(NotaCompra::class);
    }

}
