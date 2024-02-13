<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'Jose',
            'apellidos' => 'Quispe mamami',
            'email' => 'jose7895123@gmail.com',
            'password'=>bcrypt('jose7895123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'nombre' => 'pedro',
            'apellidos' => 'Quipe quiñones',
            'email' => 'pedro7895123@gmail.com',
            'password'=>bcrypt('pedro7895123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'nombre' => 'Yuli',
            'apellidos' => 'Velazques atanacio',
            'email' => 'yuli7895123@gmail.com',
            'password'=>bcrypt('yuli7895123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'nombre' => 'Vanessa',
            'apellidos' => 'Quiñones Damian',
            'email' => 'vanessa7895123@gmail.com',
            'password'=>bcrypt('vanessa7895123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'nombre' => 'Juan',
            'apellidos' => 'Damian',
            'email' => 'juan7895123@gmail.com',
            'password'=>bcrypt('juan7895123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'nombre' => 'Gabi',
            'apellidos' => 'Perez lopez',
            'email' => 'gabi7895123@gmail.com',
            'password'=>bcrypt('gabi7895123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
