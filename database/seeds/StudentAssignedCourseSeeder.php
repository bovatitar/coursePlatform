<?php

use Illuminate\Database\Seeder;

class StudentAssignedCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student_assigned_courses')->insert([
            'student_id' => 1,
            'course_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('student_assigned_courses')->insert([
            'student_id' => 2,
            'course_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('student_assigned_courses')->insert([
            'student_id' => 3,
            'course_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('student_assigned_courses')->insert([
            'student_id' => 2,
            'course_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('student_assigned_courses')->insert([
            'student_id' => 3,
            'course_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
