<?php

use Illuminate\Database\Seeder;

class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = \Illuminate\Support\Facades\DB::table('properties');
        $table->insert(['name' => 'School']);
        $table->insert(['name' => 'Class',]);
        $table->insert([ 'name' => 'Department']);
        $table->insert([ 'name' => 'Subject']);
        $table->insert([ 'name' => 'Session']);
        $table->insert([ 'name' => 'Term']);
    }
}
