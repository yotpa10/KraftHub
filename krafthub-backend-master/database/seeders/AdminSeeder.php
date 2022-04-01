<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "first_name" => "Admin",
            "last_name" => "KraftHub",
            "middle_name" => '',
            "phone_number" => '',
            "cellphone_number" => '',
            "house_info" => '',
            "street_name" => '',
            "barangay" => '',
            "city" => '',
            "zipcode" => '',
            "email" => 'admin@gmail.com',
            "password" => bcrypt('admin'),
            "access_level" => 4
        ]);
    }
}
