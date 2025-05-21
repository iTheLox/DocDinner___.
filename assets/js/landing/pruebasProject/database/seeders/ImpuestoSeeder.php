<?php

namespace Database\Seeders;

use App\Models\Impuesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImpuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pi = new Impuesto();
        $pi->nombre = "Impuest1";
        $pi->valor = 19;
        $pi->save();

        $pi = new Impuesto();
        $pi->nombre = "Impuest2";
        $pi->valor = 33;
        $pi->save();
        
        $pi = new Impuesto();
        $pi->nombre = "Impuest3";
        $pi->valor = 9;
        $pi->save();

        $pi = new Impuesto();
        $pi->nombre = "Impuest4";
        $pi->valor = 4;
        $pi->save();
        
        $pi = new Impuesto();
        $pi->nombre = "Impuest5";
        $pi->valor = 6;
        $pi->save();
       
    }
}
