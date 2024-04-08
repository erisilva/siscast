<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SituacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('situacaos')->insert(['id' => '1', 'nome' => 'Em análise', 'descricao' => 'Em análise do pedido para agendamento', 'cor' => 'primary', 'icone' => 'eye']);

        DB::table('situacaos')->insert(['id' => '2', 'nome' => 'Reprovado', 'descricao' => 'A justificativa são descritas no próprio cadastro', 'cor' => 'danger', 'icone' => 'hand-thumbs-down-fill']);

        DB::table('situacaos')->insert(['id' => '3', 'nome' => 'Agendado', 'descricao' => 'Agendamento realizado', 'cor' => 'warning', 'icone' => 'calendar-check-fill']);

        DB::table('situacaos')->insert(['id' => '4', 'nome' => 'Conclusão', 'descricao' => 'Procedimento concluído', 'cor' => 'success', 'icone' => 'hand-thumbs-up-fill']);

        DB::table('situacaos')->insert(['id' => '5', 'nome' => 'Ausente', 'descricao' => 'Não compareceu na data e hora agendada', 'cor' => 'info', 'icone' => 'calendar2-x-fill']);

        DB::table('situacaos')->insert(['id' => '6', 'nome' => 'Impossibilidade', 'descricao' => 'Não foi realizado o procedimento por motivo justificado', 'cor' => 'info', 'icone' => 'calendar2-x']);

        DB::table('situacaos')->insert(['id' => '7', 'nome' => 'Em Espera', 'descricao' => 'Cadastro aprovado pela triagem, aguarda a castração', 'cor' => 'secondary', 'icone' => 'clock']);

        DB::table('situacaos')->insert(['id' => '8', 'nome' => 'Cancelado', 'descricao' => 'Solicitante cancelou o pedido de castração', 'cor' => 'danger', 'icone' => 'x-octagon']);

        DB::table('situacaos')->insert(['id' => '9', 'nome' => 'Óbito', 'descricao' => 'Animal morreu', 'cor' => 'danger', 'icone' => 'clipboard-plus']);

        DB::table('situacaos')->insert(['id' => '10', 'nome' => 'Primeira tentativa', 'descricao' => 'Ligou a primeira vez.', 'cor' => 'primary', 'icone' => 'telephone-forward']);

    }
}
