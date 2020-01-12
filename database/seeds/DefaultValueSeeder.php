<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('default_values')->insert([
            'column_name' => 'maximum_credit',
            'value' => '5000',
            'updated_at' => $time,
            'created_at' => $time,
        ]);
    }
}
