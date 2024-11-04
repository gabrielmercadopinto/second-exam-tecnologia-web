<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nombre',
        'telefono',
        'direccion',
        'correo',
        'ci',
        'nit',
        'empresa',
    ];


    public function nota_compra()
    {
        return $this->hasMany(NotaCompra::class);
    }




}
