<?php

use Illuminate\Database\Seeder;

class TestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_types')->insert([
            'id' => 1,
            'course_id' => 2,
            'name' => "Kartkówka",
            'weight' => 1,
            'is_student_option' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('test_types')->insert([
            'id' => 2,
            'course_id' => 2,
            'name' => "Sprawdzian",
            'weight' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('test_types')->insert([
            'id' => 3,
            'course_id' => 2,
            'name' => "Odpowiedź ustna",
            'weight' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('test_types')->insert([
            'id' => 4,
            'course_id' => 2,
            'name' => "Egzamin",
            'weight' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
