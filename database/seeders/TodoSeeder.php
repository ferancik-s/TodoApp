<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => "home"
        ]);

        DB::table('categories')->insert([
            'name' => "work"
        ]);

        DB::table('categories')->insert([
            'name' => "school"
        ]);
    }
}
