<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456aB'.env('SALT_PASS')),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
