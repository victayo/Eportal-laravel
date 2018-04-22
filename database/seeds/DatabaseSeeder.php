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
        // $this->call(UsersTableSeeder::class);
        $this->call(SchoolTableSeeder::class);
        $this->call(ClassTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(SessionTableSeeder::class);
        $this->call(TermTableSeeder::class);
    }
}
