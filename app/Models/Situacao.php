<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Situacao extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome', 'descricao', 'cor', 'icone'
    ];

    public function scopeFilter($query, array $filters)
    {
        // start session values if not yet initialized
        if (!session()->exists('situacao_nome')){
            session(['situacao_nome' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'nome')) {
            session(['situacao_nome' => $filters['nome'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('situacao_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('situacao_nome') . '%');
        }
    }

    public function situacaos() : HasMany
    {
        return $this->hasMany(Situacao::class);
    }
}
