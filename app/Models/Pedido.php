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

    public function getEspecieDescricaoAttribute()
    {
        return $this->especie == 'felino' ? 'Felino' : 'Canino';
    }

    public function getGeneroDescricaoAttribute()
    {
        return $this->genero == 'M' ? 'Macho' : 'Fêmea';     
    }

    public function getPorteDescricaoAttribute()
    {
        return $this->porte == 'pequeno' ? 'Pequeno' : ($this->porte == 'medio' ? 'Médio' : 'Grande');
    }

    public function getBeneficioDescricaoAttribute()
    {
        return $this->beneficio == 'S' ? 'Sim' : 'Não';
    }

    public function getTurnoDescricaoAttribute()
    {
        return $this->agendaTurno == 'nenhum' ? 'Nenhum' : ($this->agendaTurno == 'manha' ? 'Manhã' : 'Tarde');
    }
    
    protected $dates = [
        'nascimento', 'primeiraTentativaQuando', 'segundaTentativaQuando', 'agendaQuando', 'created_at', 'updated_at'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['codigo'] ?? false, fn ($query, $codigo) => $query->where('codigo', 'like', '%' . $codigo . '%'));
        $query->when($filters['ano'] ?? false, fn ($query, $ano) => $query->where('ano', 'like', '%' . $ano . '%'));
        $query->when($filters['situacao_id'] ?? false, fn ($query, $situacao_id) => $query->where('situacao_id', '=', $situacao_id));
        $query->when($filters['nome'] ?? false, fn ($query, $nome) => $query->where('nome', 'like', '%' . $nome . '%'));
    }
}
