<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'ano', 'cpf', 'nome', 'nascimento', 'endereco', 'numero', 'bairro', 'complemento', 'cidade', 'uf', 'cep', 'email', 'tel', 'cel', 'cns', 'beneficio', 'beneficioQual', 'nomeAnimal', 'genero', 'porte', 'idade', 'idadeEm', 'cor', 'especie', 'raca_id', 'procedencia', 'situacao_id', 'primeiraTentativa', 'primeiraTentativaQuando', 'primeiraTentativaHora', 'segundaTentativa', 'segundaTentativaQuando', 'segundaTentativaHora', 'nota', 'agendaQuando', 'agendaTurno', 'motivoNaoAgendado', 'ip', 'request'
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

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['codigo'] ?? false, fn ($query, $codigo) => $query->where('codigo', 'like', '%' . $codigo . '%'));
        $query->when($filters['ano'] ?? false, fn ($query, $ano) => $query->where('ano', 'like', '%' . $ano . '%'));
        $query->when($filters['cpf'] ?? false, fn ($query, $cpf) => $query->where('cpf', 'like', '%' . $cpf . '%'));
        $query->when($filters['nome'] ?? false, fn ($query, $nome) => $query->where('nome', 'like', '%' . $nome . '%'));
    }
}
