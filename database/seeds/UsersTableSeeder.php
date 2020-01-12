<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'first_name' => 'Roberto',
            'last_name' => 'Admin',
            'dni' => '0',
            'role' => 'admin',
            'wallet' => 0,
            'commission' => 0,
            'password' => '$2y$10$NStMWdiidHnVyUeMnuRhieODxQx5cnPrX2LQdNdj5APvjB4MOj8Ti',
            'created_at' => $time,
            'updated_at' => $time
        ]);
    }
}
