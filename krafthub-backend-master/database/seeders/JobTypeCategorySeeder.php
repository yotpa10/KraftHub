<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            "id" => 1,
            'title' => "Carpentry",
            'description' => "Service for Carpentry",
        ] );
        DB::table('jobs')->insert([
            "id" => 2,
            'title' => "Plumbing",
            'description' => "Service for Plumbing",
        ]);
        DB::table('jobs')->insert([
            "id" => 3,
            'title' => "Cleaning",
            'description' => "Service for Cleaning",
        ]);
        DB::table('jobs')->insert([
            "id" => 4,
            'title' => "Electrician",
            'description' => "Service for Electrician",
        ]);
    }
}
