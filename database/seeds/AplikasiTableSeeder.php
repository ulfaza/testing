<?php

use Illuminate\Database\Seeder;

class AplikasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Aplikasi::create([
            'id'  => 1,
            'a_nama' => 'None',
            'a_url' => 'None',
            'a_file' => 'None',
            'a_nilai'  => 0
        ]);
        \App\Aplikasi::create([
            'id'  => 2,
            'a_nama' => 'Integra',
            'a_url' => 'my.its.ac.id',
            'a_file' => 'None',
            'a_nilai'  => 0
        ]);
    }
}
