<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaVenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'user_id',
        'metodo_pago_id',
        'transaccion_id',
        'total',
        'fecha',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metodo_pago()
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }


    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class);
    }
}
