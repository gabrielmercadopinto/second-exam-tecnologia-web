<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'ci',
        'nit'
    ];

    public function notaVenta()
    {
        return $this->hasMany(NotaVenta::class);
    }
}
