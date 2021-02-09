<?php

use Illuminate\Database\Seeder;

class KarakteristikTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Functional Suitability',
            'k_desc' => 'Kemampuan perangkat lunak untuk menyediakan fitur-fitur yang memenuhi
            kebutuhan dalam kondisi tertentu',
            'k_bobot' => 0.33,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Performance Efficiency',
            'k_desc' => 'Kemampuan perangkat lunak dalam performa relatif
            terhadap jumlah sumber daya yang digunakan dalam
            kondisi tertentu',
            'k_bobot' => 0.07,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Compatibility',
            'k_desc' => 'Kemampuan perangkat lunak bertukar informasi ke
            produk, sistem, atau komponen lain dan menjalankan
            fungsi yang dibutuhkan dalam lingkup perangkat keras
            atau perangkat lunak yang sama',
            'k_bobot' => 0.04,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Usability',
            'k_desc' => 'Kemampuan perangkat lunak dapat digunakan oleh pengguna yang dituju untuk mencapai suatu tujuan dengan efisien',
            'k_bobot' => 0.19,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Reliability',
            'k_desc' => 'Kemampuan perangkat lunak dalam mengerjakan sebuah fungsi
            dalam kondisi tertentu dan dalam waktu tertentu',
            'k_bobot' => 0.09,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Security',
            'k_desc' => 'Kemampuan perangkat lunak dalam melindungi informasi dan data sehingga seseorang, sistem, atau produk lain dapat mengakses data atau informasi tersebut sesuai dengan hak akses merekamasing-masing',
            'k_bobot' => 0.11,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Maintainability',
            'k_desc' => 'Kemampuan perangkat lunak untuk dimodifikasi',
            'k_bobot' => 0.13,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 1,
            'k_nama' => 'Portability',
            'k_desc' => 'Kemampuan perangkat lunak untuk dipindahkan dari suatu lingkungan operasional ke lingkungan
            operasional lain. ',
            'k_bobot' => 0.04,
            'k_nilai' => 0
        ]);

        
        //seeder integra

        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Functional Suitability',
            'k_desc' => 'Kemampuan perangkat lunak untuk menyediakan fitur-fitur yang memenuhi
            kebutuhan dalam kondisi tertentu',
            'k_bobot' => 0.33,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Performance Efficiency',
            'k_desc' => 'Kemampuan perangkat lunak dalam performa relatif
            terhadap jumlah sumber daya yang digunakan dalam
            kondisi tertentu',
            'k_bobot' => 0.07,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Compatibility',
            'k_desc' => 'Kemampuan perangkat lunak bertukar informasi ke
            produk, sistem, atau komponen lain dan menjalankan
            fungsi yang dibutuhkan dalam lingkup perangkat keras
            atau perangkat lunak yang sama',
            'k_bobot' => 0.04,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Usability',
            'k_desc' => 'Kemampuan perangkat lunak dapat digunakan oleh pengguna yang dituju untuk mencapai suatu tujuan dengan efisien',
            'k_bobot' => 0.19,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Reliability',
            'k_desc' => 'Kemampuan perangkat lunak dalam mengerjakan sebuah fungsi
            dalam kondisi tertentu dan dalam waktu tertentu',
            'k_bobot' => 0.09,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Security',
            'k_desc' => 'Kemampuan perangkat lunak dalam melindungi informasi dan data sehingga seseorang, sistem, atau produk lain dapat mengakses data atau informasi tersebut sesuai dengan hak akses merekamasing-masing',
            'k_bobot' => 0.11,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Maintainability',
            'k_desc' => 'Kemampuan perangkat lunak untuk dimodifikasi',
            'k_bobot' => 0.13,
            'k_nilai' => 0
        ]);
        \App\Karakteristik::create([
            'a_id'  => 2,
            'k_nama' => 'Portability',
            'k_desc' => 'Kemampuan perangkat lunak untuk dipindahkan dari suatu lingkungan operasional ke lingkungan
            operasional lain. ',
            'k_bobot' => 0.04,
            'k_nilai' => 0
        ]);
    }
}
