<?php

use Illuminate\Database\Seeder;

class PropertyValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table(env("PROPERTY_VALUE_TABLE"))->insert(['name' => 'GENERAL', 'property_id' => 3]);
        factory(\Eportal\Models\PropertyValue::class, 10)->create();
    }
}
