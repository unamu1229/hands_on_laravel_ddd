<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiTokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_tokens')->insert(['api_token' => 'abcd1234']);
    }
}
