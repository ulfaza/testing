<?php

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
        \App\User::create([
            'name'  => 'admin',
            'role' => 'admin',
            'instansi' => 'ITS',
            'email' => 'admin@gmail.com',
            'password'  => bcrypt('12345678')
        ]);
        \App\User::create([
            'name'  => 'Muzayyin Amrullah',
            'role' => 'softwaretester',
            'instansi' => 'ITS',
            'email' => 'zayn@gmail.com',
            'password'  => bcrypt('12345678')
        ]);
    }
}
