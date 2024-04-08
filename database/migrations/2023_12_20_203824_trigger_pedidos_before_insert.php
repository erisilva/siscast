<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
                DB::unprepared("
                
                CREATE TRIGGER `trigger_pedidos_before_insert` BEFORE INSERT ON `pedidos` FOR EACH ROW
                BEGIN
                
                    -- Obtém o ano atual
                    SET new.ano = YEAR(CURRENT_TIMESTAMP);
                
                    -- Obtém o último número inserido
                    SELECT coalesce(MAX(codigo), 0) INTO @numero FROM `pedidos` WHERE ano = NEW.ano;
                    
                    -- Incrementa o número
                    SET NEW.codigo = @numero + 1;
                
                END;
                
                ");        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `trigger_pedidos_before_insert`;');
    }
};
