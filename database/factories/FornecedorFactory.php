<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    protected $model = \App\Models\Fornecedor::class;

    public function definition()
    {
        return [
            'cnpj_cpf' => $this->faker->numerify('##############'),
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'contato' => $this->faker->phoneNumber,
            'endereco' => $this->faker->address,
        ];
    }
}
