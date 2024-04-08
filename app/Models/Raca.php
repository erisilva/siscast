<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Raca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    public function scopeFilter($query, array $filters)
    {
        // start session values if not yet initialized
        if (!session()->exists('raca_nome')){
            session(['raca_nome' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'nome')) {
            session(['raca_nome' => $filters['nome'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('raca_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('raca_nome') . '%');
        }
    }

    public function racas() : HasMany
    {
        return $this->hasMany(Raca::class);
    }
}
