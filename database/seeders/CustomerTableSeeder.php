<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->truncate();
        DB::table('customers')->insert(['name'=>'hoge',
                                        'mail'=>'hoge@hoge.com',
                                        'password'=>sha1('hogehoge'),
                                        ]);
    }
}
