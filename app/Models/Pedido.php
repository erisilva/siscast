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
        // pedido_especie
        // pedido_genero
        // pedido_porte
        // pedido_idadeMinima
        // pedido_idadeMaxima
        // pedido_idadeEm
        // pedido_procedencia
        // dataCadastroInicio
        // dataCadastroFim



        // start session values if not yet initialized
        if (!session()->exists('pedido_codigo')){
            session(['pedido_codigo' => '']);
        }

        if (!session()->exists('pedido_ano')){
            session(['pedido_ano' => '']);
        }

        if (!session()->exists('pedido_situacao_id')){
            session(['pedido_situacao_id' => '']);
        }

        if (!session()->exists('pedido_dataAgendaInicio')){
            session(['pedido_dataAgendaInicio' => '']);
        }

        if (!session()->exists('pedido_dataAgendaFim')){
            session(['pedido_dataAgendaFim' => '']);
        }

        if (!session()->exists('pedido_nome')){
            session(['pedido_nome' => '']);
        }

        if (!session()->exists('pedido_cpf')){
            session(['pedido_cpf' => '']);
        }

        if (!session()->exists('nomeAnimal')){
            session(['nomeAnimal' => '']);
        }

        if (!session()->exists('pedido_especie')){
            session(['pedido_especie' => '']);
        }

        if (!session()->exists('pedido_genero')){
            session(['pedido_genero' => '']);
        }

        if (!session()->exists('pedido_porte')){
            session(['pedido_porte' => '']);
        }

        if (!session()->exists('pedido_idadeMinima')){
            session(['pedido_idadeMinima' => '']);
        }

        if (!session()->exists('pedido_idadeMaxima')){
            session(['pedido_idadeMaxima' => '']);
        }

        if (!session()->exists('pedido_idadeEm')){
            session(['pedido_idadeEm' => '']);
        }

        if (!session()->exists('pedido_procedencia')){
            session(['pedido_procedencia' => '']);
        }

        if (!session()->exists('dataCadastroInicio')){
            session(['dataCadastroInicio' => '']);
        }

        if (!session()->exists('dataCadastroFim')){
            session(['dataCadastroFim' => '']);
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

        if (Arr::exists($filters, 'nome')) {
            session(['pedido_nome' => $filters['nome'] ?? '']);
        }

        if (Arr::exists($filters, 'cpf')) {
            $cpf = preg_replace('/[^0-9]/', '', $filters['cpf']);
            session(['pedido_cpf' => $cpf ?? '']);
        }

        if (Arr::exists($filters, 'nomeAnimal')) {
            session(['nomeAnimal' => $filters['nomeAnimal'] ?? '']);
        }

        if (Arr::exists($filters, 'especie')) {
            session(['pedido_especie' => $filters['especie'] ?? '']);
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
            session(['dataCadastroInicio' => $filters['dataCadastroInicio'] ?? '']);
        }

        if (Arr::exists($filters, 'dataCadastroFim')) {
            session(['dataCadastroFim' => $filters['dataCadastroFim'] ?? '']);
        }

        // query if session filters are not empty
        if (trim(session()->get('pedido_codigo')) !== '') {
            $query->where('codigo', session()->get('pedido_codigo'));
        }

        if (trim(session()->get('pedido_ano')) !== '') {
            $query->where('ano', session()->get('pedido_ano'));
        }

        if (trim(session()->get('pedido_situacao_id')) !== '') {
            $query->where('situacao_id', session()->get('pedido_situacao_id'));
        }

        if (trim(session()->get('pedido_dataAgendaInicio')) !== '') {
            $query->where('dataAgendaInicio', '>=', session()->get('pedido_dataAgendaInicio'));
        }

        if (trim(session()->get('pedido_dataAgendaFim')) !== '') {
            $query->where('dataAgendaFim', '<=', session()->get('pedido_dataAgendaFim'));
        }

        if (trim(session()->get('pedido_nome')) !== '') {
            $query->where('nome', 'like', '%'.session()->get('pedido_nome').'%');
        }

        if (trim(session()->get('pedido_cpf')) !== '') {
            $query->where('cpf', session()->get('pedido_cpf'));
        }

        if (trim(session()->get('nomeAnimal')) !== '') {
            $query->where('nomeAnimal', 'like', '%'.session()->get('nomeAnimal').'%');
        }

        if (trim(session()->get('pedido_especie')) !== '') {
            $query->where('especie', session()->get('pedido_especie'));
        }

        if (trim(session()->get('pedido_genero')) !== '') {
            $query->where('genero', session()->get('pedido_genero'));
        }

        if (trim(session()->get('pedido_porte')) !== '') {
            $query->where('porte', session()->get('pedido_porte'));
        }

        if (trim(session()->get('pedido_idadeMinima')) !== '') {
            $query->where('idade', '>=', session()->get('pedido_idadeMinima'));
        }

        if (trim(session()->get('pedido_idadeMaxima')) !== '') {
            $query->where('idade', '<=', session()->get('pedido_idadeMaxima'));
        }

        if (trim(session()->get('pedido_idadeEm')) !== '') {
            $query->where('idadeEm', session()->get('pedido_idadeEm'));
        }

        if (trim(session()->get('pedido_procedencia')) !== '') {
            $query->where('procedencia', 'like', '%'.session()->get('pedido_procedencia').'%');
        }

        if (trim(session()->get('dataCadastroInicio')) !== '') {
            $query->where('created_at', '>=', session()->get('dataCadastroInicio'));
        }

        if (trim(session()->get('dataCadastroFim')) !== '') {
            $query->where('created_at', '<=', session()->get('dataCadastroFim'));
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
