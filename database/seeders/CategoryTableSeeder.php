<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->truncate();
        for ($i = 0; $i < 5; $i++) {
            DB::table('category')->insert([
                'name' => 'カテゴリ' . $i,
            ]);
        }
    }
}
