<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            # Codificação interna do setor codigo/ano   
            $table->unsignedBigInteger('codigo');
            $table->unsignedBigInteger('ano');

            # dados pessoais
            $table->string('cpf', 11);
            $table->string('nome', 180);
            $table->date('nascimento');
            
            # logradouro
            $table->string('endereco', 100);
            $table->string('numero', 10);
            $table->string('bairro', 80);
            $table->string('complemento', 100)->nullable();
            $table->string('cidade', 80)->default('contagem');
            $table->string('uf', 2)->default('MG');
            $table->string('cep', 8);

            # contatos
            $table->string('email', 150);
            $table->string('tel', 15)->nullable();
            $table->string('cel', 15);

            # cartão nacional de saúde
            $table->string('cns', 15)->nullable();

            # beneficios
            $table->enum('beneficio', ['S', 'N'])->default('N');
            $table->string('beneficioQual', 100)->nullable();

            # dados dos animais
            $table->string('nomeAnimal', 100);
            $table->enum('genero', ['M', 'F']);                                
            $table->enum('porte', ['pequeno', 'medio', 'grande']);
            $table->string('idade', 4);
            $table->enum('idadeEm', ['mes', 'ano']);
            $table->string('cor', 80);
            $table->enum('especie', ['felino', 'canino']);
            $table->string('procedencia', 100);

            # agendamento, sistema atual
            $table->enum('primeiraTentativa', ['S', 'N'])->default('N');
            $table->date('primeiraTentativaQuando')->nullable();
            $table->string('primeiraTentativaHora', 5)->nullable();
            $table->enum('segundaTentativa', ['S', 'N'])->default('N');
            $table->date('segundaTentativaQuando')->nullable();
            $table->string('segundaTentativaHora', 5)->nullable();
            $table->text('nota')->nullable();
            $table->date('agendaQuando')->nullable();
            $table->enum('agendaTurno', ['manha', 'tarde', 'nenhum'])->nullable()->default('nenhum');
            $table->text('motivoNaoAgendado')->nullable();

            $table->string('ip', 200)->nullable();
            $table->text('request')->nullable();

            $table->foreignId('raca_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();

            $table->foreignId('situacao_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['raca_id']);
            $table->dropForeign(['situacao_id']);
        });

        Schema::dropIfExists('pedidos');
    }
};
