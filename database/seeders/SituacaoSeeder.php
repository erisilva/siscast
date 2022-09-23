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
        DB::table('situacaos')->insert(['id' => '1', 'nome' => 'Em análise', 'descricao' => 'Em análise do pedido para agendamento']);
        DB::table('situacaos')->insert(['id' => '2', 'nome' => 'Reprovado', 'descricao' => 'A justificativa são descritas no próprio cadastro']);
        DB::table('situacaos')->insert(['id' => '3', 'nome' => 'Agendado', 'descricao' => 'Agendamento realizado']);
        DB::table('situacaos')->insert(['id' => '4', 'nome' => 'Conclusão', 'descricao' => 'Procedimento concluído']);
        DB::table('situacaos')->insert(['id' => '5', 'nome' => 'Ausente', 'descricao' => 'Não compareceu na data e hora agendada']);
        DB::table('situacaos')->insert(['id' => '6', 'nome' => 'Impossibilidade', 'descricao' => 'Não foi realizado o procedimento por motivo justificado']);
        DB::table('situacaos')->insert(['id' => '7', 'nome' => 'Em Espera', 'descricao' => 'Cadastro aprovado pela triagem, aguarda a castração']);
        DB::table('situacaos')->insert(['id' => '8', 'nome' => 'Cancelado', 'descricao' => 'Solicitante cancelou o pedido de castração']);
        DB::table('situacaos')->insert(['id' => '9', 'nome' => 'Óbito', 'descricao' => 'Animal morreu']);
        DB::table('situacaos')->insert(['id' => '10', 'nome' => 'Primeira tentativa', 'descricao' => 'Ligou a primeira vez.']);

    }
}
