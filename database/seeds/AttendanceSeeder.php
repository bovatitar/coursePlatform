<?php

use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendances')->insert([
            'id' => 1,
            'student_id' => "3",
            'course_id' => "1",
            'lesson' => "3",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
