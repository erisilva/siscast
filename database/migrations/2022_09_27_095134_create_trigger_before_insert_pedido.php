<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class CreateTriggerBeforeInsertPedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("

                CREATE TRIGGER pedidos_before_insert
                BEFORE INSERT
                ON pedidos FOR EACH ROW

                BEGIN

                    DECLARE esseano INT;
                    
                    DECLARE novonumero INT;

                    SELECT YEAR(CURDATE()) INTO esseano;
                    
                    SELECT COALESCE(MAX(codigo) + 1, 1) INTO novonumero FROM pedidos WHERE ano = esseano;
                    
                    SET NEW.ano = esseano;
                    
                    SET NEW.codigo = novonumero;
                    
                END; 
            
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS pedidos_before_insert;');
    }
}
