<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'firstname' => "Jan",
            'Lastname' => "kowalski",
            'email' => 'jan.kowalski@titarlab.com',
            'password' => \Illuminate\Support\Facades\Hash::make("jan.qwepoi"),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'firstname' => "Volodymyr",
            'Lastname' => "admin",
            'email' => 'bovatitar@gmail.com',
            'password' => '$2y$10$SbZjNN.0ArAwaBjjSSGFG.rpHaeEOvp.8tW.eNb9seNuHh.AcshN.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
