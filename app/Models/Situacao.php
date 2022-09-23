<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'descricao',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
