<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RacaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('racas')->insert(['id' => '1', 'nome' => 'OUTRO']);
        DB::table('racas')->insert(['id' => '3', 'nome' => 'CHIUAUA']);
        DB::table('racas')->insert(['id' => '5', 'nome' => 'AKITA']);
        DB::table('racas')->insert(['id' => '6', 'nome' => 'BEAGLE']);
        DB::table('racas')->insert(['id' => '8', 'nome' => 'BASSET']);
        DB::table('racas')->insert(['id' => '9', 'nome' => 'COLLIE']);
        DB::table('racas')->insert(['id' => '10', 'nome' => 'COCKER SPANIEL']);
        DB::table('racas')->insert(['id' => '11', 'nome' => 'DALMATA']);
        DB::table('racas')->insert(['id' => '12', 'nome' => 'DOBERMAN']);
        DB::table('racas')->insert(['id' => '13', 'nome' => 'DOGUE ALEMÃO']);
        DB::table('racas')->insert(['id' => '14', 'nome' => 'FILA BRASILEIRO']);
        DB::table('racas')->insert(['id' => '15', 'nome' => 'FOX PAULISTINHA']);
        DB::table('racas')->insert(['id' => '16', 'nome' => 'HUSKY SIBERIANO']);
        DB::table('racas')->insert(['id' => '17', 'nome' => 'PASTOR ALEMÃO']);
        DB::table('racas')->insert(['id' => '18', 'nome' => 'PASTOR BELGA']);
        DB::table('racas')->insert(['id' => '20', 'nome' => 'PERDIGUEIRO']);
        DB::table('racas')->insert(['id' => '21', 'nome' => 'PINSHER']);
        DB::table('racas')->insert(['id' => '22', 'nome' => 'PIT BULL']);
        DB::table('racas')->insert(['id' => '23', 'nome' => 'POODLE']);
        DB::table('racas')->insert(['id' => '24', 'nome' => 'ROTWAILLER']);
        DB::table('racas')->insert(['id' => '25', 'nome' => 'SÃO BERNARDO']);
        DB::table('racas')->insert(['id' => '26', 'nome' => 'SHEEPDOG']);
        DB::table('racas')->insert(['id' => '27', 'nome' => 'SETTER']);
        DB::table('racas')->insert(['id' => '28', 'nome' => 'ICELANDER']);
        DB::table('racas')->insert(['id' => '29', 'nome' => 'WEIMARANER']);
        DB::table('racas')->insert(['id' => '30', 'nome' => 'YORKSHIRE']);
        DB::table('racas')->insert(['id' => '32', 'nome' => 'SIAMÊS']);
        DB::table('racas')->insert(['id' => '33', 'nome' => 'HIMALAIA']);
        DB::table('racas')->insert(['id' => '34', 'nome' => 'MAINE COON']);
        DB::table('racas')->insert(['id' => '35', 'nome' => 'ANGORÁ']);
        DB::table('racas')->insert(['id' => '36', 'nome' => 'SIBERIANO']);
        DB::table('racas')->insert(['id' => '37', 'nome' => 'SPHYNX']);
        DB::table('racas')->insert(['id' => '38', 'nome' => 'BURMESE']);
        DB::table('racas')->insert(['id' => '40', 'nome' => 'BRITISH SHORTHAIR']);
        DB::table('racas')->insert(['id' => '41', 'nome' => 'SRD']);
        DB::table('racas')->insert(['id' => '42', 'nome' => 'STAFFORDSHIRE']);
    }
}
