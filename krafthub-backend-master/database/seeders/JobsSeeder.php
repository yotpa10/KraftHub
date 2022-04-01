<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            "id" => 5,
            'title' => "Rough Carpenter",
            'description' => "Service for Rough Carpenter",
            'parent_id' => 1
        ]);
        DB::table('jobs')->insert([
            "id" => 6,
            'title' => "Joister",
            'description' => "Service for Joister",
            'parent_id' => 1
        ]);
        DB::table('jobs')->insert([
            "id" => 7,
            'title' => "Trim Carpenter",
            'description' => "Service for Trim Carpenter",
            'parent_id' => 1
        ]);
        DB::table('jobs')->insert([
            "id" => 8,
            'title' => "Cabinet maker",
            'description' => "Service for Cabinet maker",
            'parent_id' => 1
        ]);
        DB::table('jobs')->insert([
            "id" => 9,
            'title' => "Framer",
            'description' => "Service for Framer",
            'parent_id' => 1
        ]);
    }
}
