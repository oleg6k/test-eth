<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LastCheckedBlockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('last_checked_block')->get()->count() == 0) {
            DB::table('last_checked_block')->truncate();
            DB::table('last_checked_block')->insert([
                ['currency' => 'ETH', 'block_number' => 8577000]
            ]);
            DB::table('last_checked_block')->insert([
                ['currency' => 'BTC'],
                ['currency' => 'USDT']
            ]);
        }
    }
}
