<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class UserSeederOficial extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        /*
        
        Camila Cristina Guimarães - mat. 200396 - camila.guimarães@contagem.mg.gov.br
. Samantha Kellen Ribeiro Leão Araujo - mat.1556190 - samantha.araujo@contagem.mg.gov.br
. Geane Rodrigues Cruz - mat.1499834 - geanercruz@hotmail.com
. Simone Bispo da Silva Rodrigues - mat.203339 - simonebispodasilvarodrigues@gmail.com
. Michele Vieira Espindola - mat.200891 - michele.espindola@contagem.mg.gov.br
. Lenilda Aparecida Aparecida Machado dos Santos - mat.175094
. Geruza Silva Menezes - mat.200264 - gerusa
        
        
        */
        DB::table('users')->insert([
            'name' => 'Camila Cristina Guimarães',
            'email' => 'camila.guimarães@contagem.mg.gov.br',
            'active' => 'Y',
            'password' => Hash::make('200396'),
            'theme_id' => 1,
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Samantha Kellen Ribeiro Leão Araujo',
            'email' => 'samantha.araujo@contagem.mg.gov.br',
            'active' => 'Y',
            'password' => Hash::make('1556190'),
            'theme_id' => 1,
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Geane Rodrigues Cruz',
            'email' => 'geanercruz@hotmail.com',
            'active' => 'Y',
            'password' => Hash::make('1499834'),
            'theme_id' => 1,
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Simone Bispo da Silva Rodrigues',
            'email' => 'simonebispodasilvarodrigues@gmail.com',
            'active' => 'Y',
            'password' => Hash::make('203339'),
            'theme_id' => 1,
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Michele Vieira Espindola',
            'email' => 'michele.espindola@contagem.mg.gov.br',
            'active' => 'Y',
            'password' => Hash::make('200891'),
            'theme_id' => 1,
            'email_verified_at' => now(),
        ]);

    }
}
