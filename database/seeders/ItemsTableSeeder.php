<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // iOS
        // $BASE_URL = 'http://localhost';
        // Android
        $BASE_URL = 'http://10.0.2.2';

        $category = DB::table('category')->get();

        DB::table('items')->truncate();
        foreach($category as $c) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('items')->insert([
                    'name' => '商品' . $i,
                    'price' => 1000,
                    'num' => 100,
                    'category_id' => $c->id,
                    'image_path' => $BASE_URL.'/storage/images/noimage.png',
                ]);
            }
        }
    }
}
