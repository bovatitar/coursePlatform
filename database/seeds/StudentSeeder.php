<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            'id' => 1,
            'firstname' => "Eric",
            'Lastname' => "Effiong",
            'email' => 'erik.effiong@titarlab.com',
            'index' => '10101',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('students')->insert([
            'id' => 2,
            'firstname' => "Maeve",
            'Lastname' => "Wiley",
            'email' => 'maeve.wiley@titarlab.com',
            'index' => '10453',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('students')->insert([
            'id' => 3,
            'firstname' => "Volodymyr",
            'Lastname' => "Tytarenko",
            'email' => 'info@titarlab.com',
            'index' => '10743',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
