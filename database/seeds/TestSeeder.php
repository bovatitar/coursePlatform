<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tests')->insert([
            'test_type_id' => 1,
            'course_id' => 2,
            'student_id' => 3,
            'mark' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tests')->insert([
            'test_type_id' => 1,
            'course_id' => 2,
            'student_id' => 3,
            'mark' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tests')->insert([
            'test_type_id' => 1,
            'course_id' => 2,
            'student_id' => 3,
            'mark' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tests')->insert([
            'test_type_id' => 2,
            'course_id' => 2,
            'student_id' => 3,
            'mark' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tests')->insert([
            'test_type_id' => 3,
            'course_id' => 2,
            'student_id' => 3,
            'mark' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
