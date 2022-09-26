<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
            $table->string('bairro', 50);
            $table->string('complemento', 100)->nullable();
            $table->string('cidade', 50)->default('contagem');
            $table->string('uf', 2)->default('MG');
            $table->string('cep', 8);

            # contatos
            $table->string('email', 150);
            $table->string('tel', 15);
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
            $table->unsignedBigInteger('raca_id'); // FK
            $table->string('procedencia', 100);
            
            $table->unsignedBigInteger('situacao_id'); // FK

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

            $table->timestamps();

            $table->foreign('situacao_id')->references('id')->on('situacaos')->onDelete('cascade');
            $table->foreign('raca_id')->references('id')->on('racas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign('pedidos_situacao_id_foreign');
            $table->dropForeign('pedidos_raca_id_foreign');
        });

        Schema::dropIfExists('pedidos');
    }
}
