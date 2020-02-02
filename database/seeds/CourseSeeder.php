<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'id' => 1,
            'name' => "Informatyka20",
            'user_id' => "1",
            'lessons' => "15",
            'started_at' => now(),
            'ended_at' => date("Y-m-d",strtotime("2020-07-01")),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('courses')->insert([
            'id' => 2,
            'name' => "Matematyka20",
            'user_id' => "2",
            'lessons' => "15",
            'started_at' => now(),
            'ended_at' => date("Y-m-d",strtotime("2020-07-01")),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
