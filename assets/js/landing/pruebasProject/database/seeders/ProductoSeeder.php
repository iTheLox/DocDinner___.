<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'nombre' => 'Producto A',
            'descripcion' => 'Descripción A',
            'cantidad' => 100,
            'valor' => 15000.50,
            'presentacion_id' => 1, 
            'estado_id' => 1,       
            'impuesto_id' => 1      
        ]);

        Producto::create([
            'nombre' => 'Producto B',
            'descripcion' => 'Descripción B',
            'cantidad' => 50,
            'valor' => 8999.99,
            'presentacion_id' => 2,
            'estado_id' => 2,
            'impuesto_id' => 2
        ]);
        Producto::create([
            'nombre' => 'Producto C',
            'descripcion' => 'Descripción C',
            'cantidad' => 100,
            'valor' => 15000.50,
            'presentacion_id' => 3, 
            'estado_id' => 3,       
            'impuesto_id' => 3      
        ]);

        Producto::create([
            'nombre' => 'Producto C',
            'descripcion' => 'Descripción C',
            'cantidad' => 50,
            'valor' => 8999.99,
            'presentacion_id' => 4,
            'estado_id' => 4,
            'impuesto_id' => 4
        ]);
        Producto::create([
            'nombre' => 'Producto C',
            'descripcion' => 'Descripción C',
            'cantidad' => 50,
            'valor' => 8999.99,
            'presentacion_id' => 5,
            'estado_id' => 5,
            'impuesto_id' => 5
        ]);
    }
}
