<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => '03975624620',
            'codigo' => 1,
            'ano' => 2023,
            'nascimento' => $this->faker->date(),
            'logradouro' => $this->faker->streetName(),
            'numero' => $this->faker->buildingNumber(),
            'bairro' => $this->faker->city(),
            'complemento' => $this->faker->secondaryAddress(),
            'cidade' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
            'cep' => '32130000',
            'email' => $this->faker->email(),
            'tel' => $this->faker->phoneNumber(),
            'cel' => $this->faker->phoneNumber(),
            'cns' => $this->faker->numerify('##########'),
            'beneficio' => $this->faker->randomElement(['S', 'N']),
            'beneficioQual' => $this->faker->word(),
            'nomeAnimal' => $this->faker->name(),
            'genero' => $this->faker->randomElement(['M', 'F']),
            'porte' => $this->faker->randomElement(['pequeno', 'medio', 'grande']),
            'idade' => $this->faker->numerify('##'),
            'idadeEm' => $this->faker->randomElement(['mes', 'ano']),
            'cor' => $this->faker->colorName(),
            'especie' => $this->faker->randomElement(['felino', 'canino']),
            'procedencia' => $this->faker->word(),
            'primeiraTentativa' => $this->faker->randomElement(['S', 'N']),
            'primeiraTentativaQuando' => $this->faker->date(),
            'primeiraTentativaHora' => '12:00',
            'segundaTentativa'=> $this->faker->randomElement(['S', 'N']),
            'segundaTentativaQuando' => $this->faker->date(),
            'segundaTentativaHora' => '12:00',
            'nota'=> $this->faker->sentence(),
            'agendaQuando'=> $this->faker->date(),
            'agendaTurno'=> $this->faker->randomElement(['manha', 'tarde']),
            'motivoNaoAgendado'=> $this->faker->sentence(),
            'ip'=> $this->faker->ipv4(),
            'request'=> $this->faker->sentence(),
            'raca_id'=> \App\Models\Raca::inRandomOrder()->first()->id,
            'situacao_id'=> \App\Models\Situacao::inRandomOrder()->first()->id,


            
        ];
    }
}
