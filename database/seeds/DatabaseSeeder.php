<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             StudentSeeder::class,
             TestTypeSeeder::class,
             UserSeeder::class,
             CourseSeeder::class,
             StudentAssignedCourseSeeder::class,
             AttendanceSeeder::class,
             TestSeeder::class,
         ]);
    }
}
