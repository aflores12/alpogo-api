<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Alan',
            'last_name' => 'Flores',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'token' => str_random(10),
            'last_login' => '27-12-2016',
            'passport' => 34335174
        ]);

        DB::table('roles')->insert([
            'name' => 'Administrador',
            'description' => 'Administrador de alpogo',
            'slug' => str_slug('administrador')
        ]);

        DB::table('roles')->insert([
            'name' => 'Artista',
            'description' => 'Artista de alpogo',
            'slug' => str_slug('artista')
        ]);

        DB::table('roles')->insert([
            'name' => 'Productor',
            'description' => 'Productor de alpogo',
            'slug' => str_slug('productor')
        ]);

        DB::table('permissions')->insert([
            'name' => 'Crear usuarios',
            'description' => 'Puede crear usuarios',
            'slug' => str_slug('crear usuarios')
        ]);

        DB::table('permissions')->insert([
            'name' => 'Editar usuarios',
            'description' => 'Puede editar usuarios',
            'slug' => str_slug('editar usuarios')
        ]);

    }
}