<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            'name' => 'AP 100',
            'id_owner' => '1'
        ]);
        DB::table('units')->insert([
            'name' => 'AP 200',
            'id_owner' => '1'
        ]);
        DB::table('units')->insert([
            'name' => 'AP 300',
            'id_owner' => ''
        ]);
        DB::table('units')->insert([
            'name' => 'AP 400',
            'id_owner' => ''
        ]);
        DB::table('areas')->insert([
            'allowed' => 'AP 400',
            'title' => 'Academia',
            'cover' => 'gym.jpg',
            'days' => '1,2,4,5',
            'start_time' => '08:00:00',
            'end_time' => '18:00:00'
        ]);
        DB::table('areas')->insert([
            'allowed' => 'AP 400',
            'title' => 'Piscina',
            'cover' => 'pool.jpg',
            'days' => '1,2,3,4,5',
            'start_time' => '08:00:00',
            'end_time' => '18:00:00'
        ]);
        DB::table('areas')->insert([
            'allowed' => 'AP 400',
            'title' => 'Área de lazer',
            'cover' => 'playground.jpg',
            'days' => '1,2,3,4,5',
            'start_time' => '08:00:00',
            'end_time' => '18:00:00',
        ]);
        DB::table('walls')->insert([
            'title' => 'Título de aviso de teste',
            'body' => 'Lorem Ipsum',
            'date_created' => '2020-12-20 15:00:00'
        ]);
        DB::table('walls')->insert([
            'title' => 'Alerta geral para todos',
            'body' => 'Lorem Ipsum',
            'date_created' => '2020-12-20 15:00:00'
        ]);
    }
}
