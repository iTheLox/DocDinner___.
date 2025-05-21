<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Estado;
use App\Models\Impuesto;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Estado::factory(5)->create();
        Impuesto::factory(5)->create();
        Presentacion::factory(5)->create();
        Producto::factory(5)->create();
    }
}
