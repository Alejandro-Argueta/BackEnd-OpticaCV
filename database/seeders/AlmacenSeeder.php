<?php

namespace Database\Seeders;

use App\Models\Almacenes;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombresAlmacenes = [
            'La Pinta',
            'La Niña',
            'La Santa Maria',
        ];

        foreach ($nombresAlmacenes as $nombre) {
            Almacenes::create([
                'nombre' => $nombre,
            ]);
        }
    }
}
