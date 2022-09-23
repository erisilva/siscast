<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class RacaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

DB::table('racas')->insert(['id' => '1', 'descricao' => 'OUTRO']);
DB::table('racas')->insert(['id' => '3', 'descricao' => 'CHIUAUA']);
DB::table('racas')->insert(['id' => '5', 'descricao' => 'AKITA']);
DB::table('racas')->insert(['id' => '6', 'descricao' => 'BEAGLE']);
DB::table('racas')->insert(['id' => '8', 'descricao' => 'BASSET']);
DB::table('racas')->insert(['id' => '9', 'descricao' => 'COLLIE']);
DB::table('racas')->insert(['id' => '10', 'descricao' => 'COCKER SPANIEL']);
DB::table('racas')->insert(['id' => '11', 'descricao' => 'DALMATA']);
DB::table('racas')->insert(['id' => '12', 'descricao' => 'DOBERMAN']);
DB::table('racas')->insert(['id' => '13', 'descricao' => 'DOGUE ALEMÃO']);
DB::table('racas')->insert(['id' => '14', 'descricao' => 'FILA BRASILEIRO']);
DB::table('racas')->insert(['id' => '15', 'descricao' => 'FOX PAULISTINHA']);
DB::table('racas')->insert(['id' => '16', 'descricao' => 'HUSKY SIBERIANO']);
DB::table('racas')->insert(['id' => '17', 'descricao' => 'PASTOR ALEMÃƒO']);
DB::table('racas')->insert(['id' => '18', 'descricao' => 'PASTOR BELGA']);
DB::table('racas')->insert(['id' => '20', 'descricao' => 'PERDIGUEIRO']);
DB::table('racas')->insert(['id' => '21', 'descricao' => 'PINSHER']);
DB::table('racas')->insert(['id' => '22', 'descricao' => 'PIT BULL']);
DB::table('racas')->insert(['id' => '23', 'descricao' => 'POODLE']);
DB::table('racas')->insert(['id' => '24', 'descricao' => 'ROTWAILLER']);
DB::table('racas')->insert(['id' => '25', 'descricao' => 'SÃO BERNARDO']);
DB::table('racas')->insert(['id' => '26', 'descricao' => 'SHEEPDOG']);
DB::table('racas')->insert(['id' => '27', 'descricao' => 'SETTER']);
DB::table('racas')->insert(['id' => '28', 'descricao' => 'ICELANDER']);
DB::table('racas')->insert(['id' => '29', 'descricao' => 'WEIMARANER']);
DB::table('racas')->insert(['id' => '30', 'descricao' => 'YORKSHIRE']);
DB::table('racas')->insert(['id' => '32', 'descricao' => 'SIAMÊS']);
DB::table('racas')->insert(['id' => '33', 'descricao' => 'HIMALAIA']);
DB::table('racas')->insert(['id' => '34', 'descricao' => 'MAINE COON']);
DB::table('racas')->insert(['id' => '35', 'descricao' => 'ANGORÃ']);
DB::table('racas')->insert(['id' => '36', 'descricao' => 'SIBERIANO']);
DB::table('racas')->insert(['id' => '37', 'descricao' => 'SPHYNX']);
DB::table('racas')->insert(['id' => '38', 'descricao' => 'BURMESE']);
DB::table('racas')->insert(['id' => '40', 'descricao' => 'BRITISH SHORTHAIR']);
DB::table('racas')->insert(['id' => '41', 'descricao' => 'SRD']);
DB::table('racas')->insert(['id' => '42', 'descricao' => 'STAFFORDSHIRE']);

    }
}
