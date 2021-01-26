<?php

use Illuminate\Database\Seeder;

class SubkarakteristikTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\SubKarakteristik::create([
            'k_id'  => 1,
            'sk_nama' => 'Functional Completeness',
            'sk_desc' => '',
            'bobot_relatif' => 0.16
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 1,
            'sk_nama' => 'Functional Correctness',
            'sk_desc' => '',
            'bobot_relatif' => 0.51
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 1,
            'sk_nama' => 'Functional Appropriateness',
            'sk_desc' => '',
            'bobot_relatif' => 0.33
        ]);
        
        \App\SubKarakteristik::create([
            'k_id'  => 2,
            'sk_nama' => 'Time Behaviour',
            'sk_desc' => '',
            'bobot_relatif' => 0.49
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 2,
            'sk_nama' => 'Resource Utilization',
            'sk_desc' => '',
            'bobot_relatif' => 0.31
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 2,
            'sk_nama' => 'Capacity',
            'sk_desc' => '',
            'bobot_relatif' => 0.20
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 3,
            'sk_nama' => 'Co-Existence',
            'sk_desc' => '',
            'bobot_relatif' => 0.75
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 3,
            'sk_nama' => 'Interoperability',
            'sk_desc' => '',
            'bobot_relatif' => 0.25
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Appropriateness Recognizability',
            'sk_desc' => 'Sejauh mana pengguna dapat mengenali apakah produk atau sistem dapat memenuhi kebutuhan',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Learnability',
            'sk_desc' => 'Sejauh mana sebuah produk atau sistem dapat digunakan oleh pengguna untuk mencapai suatu tujuan dengan mempelajari produk tersebut dengan efektif dan efisien',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Operability',
            'sk_desc' => 'Sejauh mana produk atau sistem memiliki atribut yang memudahkan penggunaan',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'User Error Protection',
            'sk_desc' => 'Sejauh mana sebuah sistem dapat melindungi pengguna dari error',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'User Interface Aesthetics',
            'sk_desc' => 'Sejauh mana User Interface dapat menyediakan interaksi yang memuaskan pengguna',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Accessibility',
            'sk_desc' => 'Sejauh mana produk atau sistem dapat digunakan oleh berbagai macam karakteristik dan kapabilitas pengguna untuk memenuhi suatu kebutuhan',
            'bobot_relatif' => 0.17
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Maturity',
            'sk_desc' => '',
            'bobot_relatif' => 0.19
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Availability',
            'sk_desc' => '',
            'bobot_relatif' => 0.33
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Fault-Tolerance',
            'sk_desc' => '',
            'bobot_relatif' => 0.24
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Recoverability',
            'sk_desc' => '',
            'bobot_relatif' => 0.24
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Confidentiality',
            'sk_desc' => 'Sejauh mana suatu data pada sistem atau produk hanya dapat diakses oleh pengguna yang memiliki hak akses',
            'bobot_relatif' => 0.15
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Integrity',
            'sk_desc' => 'Sejauh mana sebuah sistem mencegah akses tak dikenal yang dapat memodifikasi sistem tersebut',
            'bobot_relatif' => 0.33
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Non-repudiation',
            'sk_desc' => 'Sejauh mana setiap aksi atau peristiwa yang terjadi pada sistem dapat dibuktikan ketika dibutuhkan',
            'bobot_relatif' => 0.11
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Authenticity',
            'sk_desc' => 'Sejauh mana aksi dari sebuah komponen dapat dilacak secara unik ke komponen tersebut',
            'bobot_relatif' => 0.19
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Accountability',
            'sk_desc' => 'Sejauh mana identitas suatu subjek atau sumber daya dapat dibuktikan oleh orang yang melakukan klaim terhadap identitas tersebut',
            'bobot_relatif' => 0.22
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Modularity',
            'sk_desc' => '',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Reusability',
            'sk_desc' => '',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Analysability',
            'sk_desc' => '',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Modifiability',
            'sk_desc' => '',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Testability',
            'sk_desc' => '',
            'bobot_relatif' => 0.20
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 8,
            'sk_nama' => 'Adaptability',
            'sk_desc' => '',
            'bobot_relatif' => 0.25
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 8,
            'sk_nama' => 'Installability',
            'sk_desc' => '',
            'bobot_relatif' => 0.75
        ]);
    }
}
    