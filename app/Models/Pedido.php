<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'ano', 'cpf', 'nome', 'nascimento', 'endereco', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'cep', 'email', 'tel', 'cel', 'cns', 'beneficio', 'beneficioQual', 'nomeAnimal', 'genero', 'porte', 'idade', 'idadeEm', 'cor', 'especie', 'raca_id', 'procedencia', 'situacao_id', 'primeiraTentativa', 'primeiraTentativaQuando', 'primeiraTentativaHora', 'segundaTentativa', 'segundaTentativaQuando', 'segundaTentativaHora', 'nota', 'agendaQuando', 'agendaTurno', 'motivoNaoAgendado'
    ];

    public function raca()
    {
        return $this->belongsTo(Raca::class);
    }

    public function situacao()
    {
        return $this->belongsTo(Situacao::class);
    }
    
    protected $dates = [
        'nascimento', 'primeiraTentativaQuando', 'segundaTentativaQuando', 'agendaQuando', 'created_at', 'updated_at'
    ];
}
