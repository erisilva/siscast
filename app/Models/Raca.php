<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raca extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
