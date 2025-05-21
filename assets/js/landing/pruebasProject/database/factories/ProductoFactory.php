<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\Impuesto;
use App\Models\Presentacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'descripcion' => $this->faker->name(),
            'cantidad' => $this->faker->randomNumber(),
            'valor' => $this->faker->randomFloat(),
            'presentacion_id' => Presentacion::inRandomOrder()->value('id'),
            'estado_id'        => Estado::inRandomOrder()->value('id'),
            'impuesto_id'      => Impuesto::inRandomOrder()->value('id'),
        ];
    }
}
