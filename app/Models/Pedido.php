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
        'codigo',
        'ano',
        'cpf',
        'nome',
        'nascimento',
        'logradouro',
        'numero',
        'bairro',
        'complemento',
        'cidade',
        'uf',
        'cep',
        'email',
        'tel',
        'cel',
        'cns',
        'beneficio',
        'beneficioQual',
        'nomeAnimal',
        'genero',
        'porte',
        'idade',
        'idadeEm',
        'cor',
        'especie',
        'procedencia',
        'primeiraTentativa',
        'primeiraTentativaQuando',
        'primeiraTentativaHora',
        'segundaTentativa',
        'segundaTentativaQuando',
        'segundaTentativaHora',
        'nota',
        'agendaQuando',
        'agendaTurno',
        'motivoNaoAgendado',
        'ip',
        'request',
        'raca_id',
        'situacao_id',
    ];

    protected $casts = [
        'nascimento' => 'date',
        'primeiraTentativaQuando' => 'date',
        'segundaTentativaQuando' => 'date',
        'agendaQuando' => 'date',
        'created_at' => 'date',
    ];

    public function scopeFilter($query, array $filters)
    {

        // pedido_codigo
        // pedido_ano
        // pedido_situacao_id
        // pedido_dataAgendaInicio
        // pedido_dataAgendaFim
        // pedido_turno
        // pedido_nome
        // pedido_cpf
        // pedido_cidade
        // nomeAnimal
        // pedido_especie
        // pedido_genero
        // pedido_porte
        // pedido_idadeMinima
        // pedido_idadeMaxima
        // pedido_idadeEm
        // pedido_procedencia
        // dataCadastroInicio
        // dataCadastroFim

        //'codigo' => request()->input('pedido_codigo'),'ano' => request()->input('pedido_ano'),'situacao_id' => request()->input('pedido_situacao_id'),'dataAgendaInicio' => request()->input('pedido_dataAgendaInicio'),'dataAgendaFim' => request()->input('pedido_dataAgendaFim'),'nome' => request()->input('pedido_nome'),'cpf' => request()->input('pedido_cpf'),'nomeAnimal' => request()->input('pedido_nomeAnimal'),'especie' => request()->input('pedido_especie'),'genero' => request()->input('pedido_genero'),'porte' => request()->input('pedido_porte'),'idadeMinima' => request()->input('pedido_idadeMinima'),'idadeMaxima' => request()->input('pedido_idadeMaxima'),'idadeEm' => request()->input('pedido_IdadeEm'),'procedencia' => request()->input('pedido_procedencia'),'dataCadastroInicio' => request()->input('pedido_dataCadastroInicio'),'dataCadastroFim' => request()->input('pedido_dataCadastroFim'),'raca_id' => request()->input('pedido_raca_id')



        // start session values if not yet initialized
        if (!session()->exists('pedido_codigo')) {
            session(['pedido_codigo' => '']);
        }

        if (!session()->exists('pedido_ano')) {
            session(['pedido_ano' => '']);
        }

        if (!session()->exists('pedido_situacao_id')) {
            session(['pedido_situacao_id' => '']);
        }

        if (!session()->exists('pedido_dataAgendaInicio')) {
            session(['pedido_dataAgendaInicio' => '']);
        }

        if (!session()->exists('pedido_dataAgendaFim')) {
            session(['pedido_dataAgendaFim' => '']);
        }

        if (!session()->exists('pedido_turno')) {
            session(['pedido_turno' => '']);
        }

        if (!session()->exists('pedido_nome')) {
            session(['pedido_nome' => '']);
        }

        if (!session()->exists('pedido_cpf')) {
            session(['pedido_cpf' => '']);
        }

        if (!session()->exists('pedido_cidade')) {
            session(['pedido_cidade' => '']);
        }

        if (!session()->exists('pedido_nomeAnimal')) {
            session(['pedido_nomeAnimal' => '']);
        }

        if (!session()->exists('pedido_especie')) {
            session(['pedido_especie' => '']);
        }

        if (!session()->exists('pedido_raca_id')) {
            session(['pedido_raca_id' => '']);
        }

        if (!session()->exists('pedido_genero')) {
            session(['pedido_genero' => '']);
        }

        if (!session()->exists('pedido_porte')) {
            session(['pedido_porte' => '']);
        }

        if (!session()->exists('pedido_idadeMinima')) {
            session(['pedido_idadeMinima' => '']);
        }

        if (!session()->exists('pedido_idadeMaxima')) {
            session(['pedido_idadeMaxima' => '']);
        }

        if (!session()->exists('pedido_idadeEm')) {
            session(['pedido_idadeEm' => '']);
        }

        if (!session()->exists('pedido_procedencia')) {
            session(['pedido_procedencia' => '']);
        }

        if (!session()->exists('pedido_dataCadastroInicio')) {
            session(['pedido_dataCadastroInicio' => '']);
        }

        if (!session()->exists('pedido_dataCadastroFim')) {
            session(['pedido_dataCadastroFim' => '']);
        }


        // update session values if the request has a value
        if (Arr::exists($filters, 'codigo')) {
            session(['pedido_codigo' => $filters['codigo'] ?? '']);
        }

        if (Arr::exists($filters, 'ano')) {
            session(['pedido_ano' => $filters['ano'] ?? '']);
        }

        if (Arr::exists($filters, 'situacao_id')) {
            session(['pedido_situacao_id' => $filters['situacao_id'] ?? '']);
        }

        if (Arr::exists($filters, 'dataAgendaInicio')) {
            session(['pedido_dataAgendaInicio' => $filters['dataAgendaInicio'] ?? '']);
        }

        if (Arr::exists($filters, 'dataAgendaFim')) {
            session(['pedido_dataAgendaFim' => $filters['dataAgendaFim'] ?? '']);
        }

        if (Arr::exists($filters, 'turno')) {
            session(['pedido_turno' => $filters['turno'] ?? '']);
        }

        if (Arr::exists($filters, 'nome')) {
            session(['pedido_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'cpf')) {
            $cpf = preg_replace('/[^0-9]/', '', $filters['cpf']);
            session(['pedido_cpf' => $cpf ?? '']);
        }

        if (Arr::exists($filters, 'cidade')) {
            session(['pedido_cidade' => $filters['cidade'] ?? '']);
        }

        if (Arr::exists($filters, 'nomeAnimal')) {
            session(['pedido_nomeAnimal' => $filters['nomeAnimal'] ?? '']);
        }

        if (Arr::exists($filters, 'especie')) {
            session(['pedido_especie' => $filters['especie'] ?? '']);
        }

        if (Arr::exists($filters, 'raca_id')) {
            session(['pedido_raca_id' => $filters['raca_id'] ?? '']);
        }

        if (Arr::exists($filters, 'genero')) {
            session(['pedido_genero' => $filters['genero'] ?? '']);
        }

        if (Arr::exists($filters, 'porte')) {
            session(['pedido_porte' => $filters['porte'] ?? '']);
        }

        if (Arr::exists($filters, 'idadeMinima')) {
            session(['pedido_idadeMinima' => $filters['idadeMinima'] ?? '']);
        }

        if (Arr::exists($filters, 'idadeMaxima')) {
            session(['pedido_idadeMaxima' => $filters['idadeMaxima'] ?? '']);
        }

        if (Arr::exists($filters, 'idadeEm')) {
            session(['pedido_idadeEm' => $filters['idadeEm'] ?? '']);
        }

        if (Arr::exists($filters, 'procedencia')) {
            session(['pedido_procedencia' => $filters['procedencia'] ?? '']);
        }

        if (Arr::exists($filters, 'dataCadastroInicio')) {
            session(['pedido_dataCadastroInicio' => $filters['dataCadastroInicio'] ?? '']);
        }

        if (Arr::exists($filters, 'dataCadastroFim')) {
            session(['pedido_dataCadastroFim' => $filters['dataCadastroFim'] ?? '']);
        }

        // query if session filters are not empty
        if (trim((string) session()->get('pedido_codigo')) !== '') {
            $query->where('codigo', session()->get('pedido_codigo'));
        }

        if (trim((string) session()->get('pedido_ano')) !== '') {
            $query->where('ano', session()->get('pedido_ano'));
        }

        if (trim((string) session()->get('pedido_situacao_id')) !== '') {
            $query->where('situacao_id', session()->get('pedido_situacao_id'));
        }

        if (trim((string) session()->get('pedido_dataAgendaInicio')) !== '') {
            $query->where('agendaQuando', '>=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('pedido_dataAgendaInicio')))));
        }

        if (trim((string) session()->get('pedido_dataAgendaFim')) !== '') {
            $query->where('agendaQuando', '<=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('pedido_dataAgendaFim')))));
        }

        if (trim((string) session()->get('pedido_turno')) !== '') {
            $query->where('agendaTurno', session()->get('pedido_turno'));
        }

        if (trim((string) session()->get('pedido_nome')) !== '') {
            $query->where('nome', 'like', '%' . session()->get('pedido_nome') . '%');
        }

        if (trim((string) session()->get('pedido_cpf')) !== '') {
            $query->where('cpf', session()->get('pedido_cpf'));
        }

        if (trim((string) session()->get('pedido_cidade')) !== '') {
            $query->where('cidade', 'like', '%' . session()->get('pedido_cidade') . '%');
        }

        if (trim((string) session()->get('pedido_nomeAnimal')) !== '') {
            $query->where('nomeAnimal', 'like', '%' . session()->get('pedido_nomeAnimal') . '%');
        }

        if (trim((string) session()->get('pedido_especie')) !== '') {
            $query->where('especie', session()->get('pedido_especie'));
        }

        if (trim((string) session()->get('pedido_raca_id')) !== '') {
            $query->where('raca_id', session()->get('pedido_raca_id'));
        }

        if (trim((string) session()->get('pedido_genero')) !== '') {
            $query->where('genero', session()->get('pedido_genero'));
        }

        if (trim((string) session()->get('pedido_porte')) !== '') {
            $query->where('porte', session()->get('pedido_porte'));
        }

        if (trim((string) session()->get('pedido_idadeMinima')) !== '') {
            $query->where('idade', '>=', session()->get('pedido_idadeMinima'));
        }

        if (trim((string) session()->get('pedido_idadeMaxima')) !== '') {
            $query->where('idade', '<=', session()->get('pedido_idadeMaxima'));
        }

        if (trim((string) session()->get('pedido_idadeEm')) !== '') {
            $query->where('idadeEm', session()->get('pedido_idadeEm'));
        }

        if (trim((string) session()->get('pedido_procedencia')) !== '') {
            $query->where('procedencia', 'like', '%' . session()->get('pedido_procedencia') . '%');
        }

        if (trim((string) session()->get('pedido_dataCadastroInicio')) !== '') {
            $query->where('created_at', '>=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('pedido_dataCadastroInicio')))));
        }

        if (trim((string) session()->get('pedido_dataCadastroFim')) !== '') {
            $query->where('created_at', '<=', date('Y-m-d', strtotime(str_replace('/', '-', session()->get('pedido_dataCadastroFim')))));
        }

    }

    public function raca(): BelongsTo
    {
        return $this->belongsTo(Raca::class);
    }

    public function situacao(): BelongsTo
    {
        return $this->belongsTo(Situacao::class);
    }

}
