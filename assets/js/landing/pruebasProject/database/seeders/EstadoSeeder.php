<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pi = new Estado();
        $pi->nombre = "Excelente";
        $pi->save();

        $pi = new Estado();
        $pi->nombre = "Aprobable";
        $pi->save();

        $pi = new Estado();
        $pi->nombre = "Bueno";
        $pi->save();

        $pi = new Estado();
        $pi->nombre = "Pesimo";
        $pi->save();

        $pi = new Estado();
        $pi->nombre = "Malo";
        $pi->save();
    }
}
