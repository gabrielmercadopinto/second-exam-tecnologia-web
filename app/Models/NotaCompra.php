<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'total',
        'estado',
        'user_id',
        'proveedor_id'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalle_compra()
    {
        return $this->hasMany(DetalleVenta::class);
    }


}
