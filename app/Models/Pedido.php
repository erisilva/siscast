<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
            'codigo','ano','cpf','nome','nascimento','logradouro','numero','bairro','complemento','cidade','uf','cep','email','tel','cel','cns','beneficio','beneficioQual','nomeAnimal','genero','porte','idade','idadeEm','cor','especie','procedencia','primeiraTentativa','primeiraTentativaQuando','primeiraTentativaHora','segundaTentativa','segundaTentativaQuando','segundaTentativaHora','nota','agendaQuando','agendaTurno','motivoNaoAgendado','ip','request','raca_id','situacao_id',
    ];

    protected $casts = [
        'nascimento' => 'date',
        'primeiraTentativaQuando' => 'date',
        'segundaTentativaQuando'=> 'date',
        'agendaQuando'=> 'date',
        'created_at'=> 'date',
      ];

    public function scopeFilter($query, array $filters)
    {

        // pedido_codigo
        // pedido_ano
        // pedido_situacao_id
        // pedido_dataAgendaInicio
        // pedido_dataAgendaFim
        // pedido_nome
        // pedido_cpf
        // nomeAnimal
        // pedido_raca_id ????



        // start session values if not yet initialized
        if (!session()->exists('pedido_nome')){
            session(['pedido_nome' => '']);
        }

        // update session values if the request has a value
        if (Arr::exists($filters, 'nome')) {
            session(['pedido_nome' => $filters['nome'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('pedido_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('pedido_nome') . '%');
        }
    }

    public function raca() : BelongsTo
    {
        return $this->belongsTo(Raca::class);
    }

    public function situacao() : BelongsTo
    {
        return $this->belongsTo(Situacao::class);
    }

}
