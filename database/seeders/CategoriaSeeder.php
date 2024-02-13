<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $datos = [
            [
                'nombre'=> 'monitores',
                'descripcion'=> Str::random(20)
            ],
            [
                'nombre'=> 'teclados',
                'descripcion'=> Str::random(20)
            ],
            [
                'nombre'=> 'mouses',
                'descripcion'=> Str::random(20)
            ],
            [
                'nombre'=> 'laptops',
                'descripcion'=> Str::random(20)
            ],
        ];

        Categoria::insert($datos);
    }
}
