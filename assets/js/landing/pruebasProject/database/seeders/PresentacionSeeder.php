<?php

namespace Database\Seeders;

use App\Models\Presentacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presentaciones = [
            'Unidad',
            'Caja',
            'Paquete',
            'Litro',
            'Kilogramo',
        ];

        foreach ($presentaciones as $nombre) {
            Presentacion::create(['nombre' => $nombre]);
        }
    }
}
