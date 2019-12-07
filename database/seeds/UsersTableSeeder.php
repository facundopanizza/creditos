<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'first_name' => 'Roberto',
            'last_name' => 'Admin',
            'dni' => '0',
            'role' => 'admin',
            'wallet' => 0,
            'commission' => 0,
            'password' => '$2y$10$NStMWdiidHnVyUeMnuRhieODxQx5cnPrX2LQdNdj5APvjB4MOj8Ti',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
