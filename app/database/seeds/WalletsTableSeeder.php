<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('wallets')->get()->count() == 0) {
            DB::table('wallets')->truncate();
            DB::table('wallets')->insert([
                ['address' => '0xEA674fdDe714fd979de3EdF0F56AA9716B898ec8'],
                ['address' => '0x5A0b54D5dc17e0AadC383d2db43B0a0D3E029c4c']
            ]);
        }
    }

}
