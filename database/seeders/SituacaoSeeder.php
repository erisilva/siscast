<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class SituacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('situacaos')->insert(['id' => '1', 'nome' => 'Em análise', 'descricao' => 'Em análise do pedido para agendamento', 'cor' => 'btn-primary', 'icone' => 'bi bi-eye']);

        DB::table('situacaos')->insert(['id' => '2', 'nome' => 'Reprovado', 'descricao' => 'A justificativa são descritas no próprio cadastro', 'cor' => 'btn-danger', 'icone' => 'bi bi-hand-thumbs-down-fill']);

        DB::table('situacaos')->insert(['id' => '3', 'nome' => 'Agendado', 'descricao' => 'Agendamento realizado', 'cor' => 'btn-warning', 'icone' => 'bi bi-calendar-check-fill']);

        DB::table('situacaos')->insert(['id' => '4', 'nome' => 'Conclusão', 'descricao' => 'Procedimento concluído', 'cor' => 'btn-success', 'icone' => 'bi bi-hand-thumbs-up-fill']);

        DB::table('situacaos')->insert(['id' => '5', 'nome' => 'Ausente', 'descricao' => 'Não compareceu na data e hora agendada', 'cor' => 'btn-info', 'icone' => 'bi bi-calendar2-x-fill']);

        DB::table('situacaos')->insert(['id' => '6', 'nome' => 'Impossibilidade', 'descricao' => 'Não foi realizado o procedimento por motivo justificado', 'cor' => 'btn-info', 'icone' => 'bi bi-calendar2-x']);

        DB::table('situacaos')->insert(['id' => '7', 'nome' => 'Em Espera', 'descricao' => 'Cadastro aprovado pela triagem, aguarda a castração', 'cor' => 'btn-secondary', 'icone' => 'bi bi-clock']);

        DB::table('situacaos')->insert(['id' => '8', 'nome' => 'Cancelado', 'descricao' => 'Solicitante cancelou o pedido de castração', 'cor' => 'btn-danger', 'icone' => 'bi bi-x-octagon']);

        DB::table('situacaos')->insert(['id' => '9', 'nome' => 'Óbito', 'descricao' => 'Animal morreu', 'cor' => 'btn-danger', 'icone' => 'bi-clipboard-plus']);

        DB::table('situacaos')->insert(['id' => '10', 'nome' => 'Primeira tentativa', 'descricao' => 'Ligou a primeira vez.', 'cor' => 'btn-primary', 'icone' => 'bi bi-telephone-forward']);

    }
}
