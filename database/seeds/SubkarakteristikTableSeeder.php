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
            'bobot_relatif' => 0.16
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 1,
            'sk_nama' => 'Functional Correctness',
            'bobot_relatif' => 0.51
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 1,
            'sk_nama' => 'Functional Appropriateness',
            'bobot_relatif' => 0.33
        ]);
        
        \App\SubKarakteristik::create([
            'k_id'  => 2,
            'sk_nama' => 'Time Behaviour',
            'bobot_relatif' => 0.49
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 2,
            'sk_nama' => 'Resource Utilization',
            'bobot_relatif' => 0.31
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 2,
            'sk_nama' => 'Capacity',
            'bobot_relatif' => 0.20
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 3,
            'sk_nama' => 'Co-Existence',
            'bobot_relatif' => 0.75
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 3,
            'sk_nama' => 'Interoperability',
            'bobot_relatif' => 0.25
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Appropriateness Recognizability',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Learnability',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Operability',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'User Error Protection',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'User Interface Aesthetics',
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 4,
            'sk_nama' => 'Accessibility',
            'bobot_relatif' => 0.17
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Maturity',
            'bobot_relatif' => 0.19
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Availability',
            'bobot_relatif' => 0.33
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Fault-Tolerance',
            'bobot_relatif' => 0.24
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 5,
            'sk_nama' => 'Recoverability',
            'bobot_relatif' => 0.24
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Confidentiality',
            'bobot_relatif' => 0.15
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Integrity',
            'bobot_relatif' => 0.33
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Non-repudiation',
            'bobot_relatif' => 0.11
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Authenticity',
            'bobot_relatif' => 0.19
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 6,
            'sk_nama' => 'Accountability',
            'bobot_relatif' => 0.22
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Modularity',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Reusability',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Analysability',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Modifiability',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 7,
            'sk_nama' => 'Testability',
            'bobot_relatif' => 0.20
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 8,
            'sk_nama' => 'Adaptability',
            'bobot_relatif' => 0.25
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 8,
            'sk_nama' => 'Installability',
            'bobot_relatif' => 0.75
        ]);

        //seeder integra

        \App\SubKarakteristik::create([
            'k_id'  => 9,
            'sk_nama' => 'Functional Completeness',
            'jml_res' => 119,
            'total_per_sub' => 388,
            'bobot_relatif' => 0.16
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 9,
            'sk_nama' => 'Functional Correctness',
            'jml_res' => 119,
            'total_per_sub' => 381,
            'bobot_relatif' => 0.51
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 9,
            'sk_nama' => 'Functional Appropriateness',
            'jml_res' => 119,
            'total_per_sub' => 392,
            'bobot_relatif' => 0.33
        ]);
        
        \App\SubKarakteristik::create([
            'k_id'  => 10,
            'sk_nama' => 'Time Behaviour',
            'bobot_relatif' => 0.49
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 10,
            'sk_nama' => 'Resource Utilization',
            'jml_res' => 16,
            'total_per_sub' => 51,
            'bobot_relatif' => 0.31
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 10,
            'sk_nama' => 'Capacity',
            'bobot_relatif' => 0.20
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 11,
            'sk_nama' => 'Co-Existence',
            'jml_res' => 119,
            'total_per_sub' => 411,
            'bobot_relatif' => 0.75
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 11,
            'sk_nama' => 'Interoperability',
            'jml_res' => 16,
            'total_per_sub' => 42,
            'bobot_relatif' => 0.25
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 12,
            'sk_nama' => 'Appropriateness Recognizability',
            'jml_res' => 119,
            'total_per_sub' => 394,
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 12,
            'sk_nama' => 'Learnability',
            'jml_res' => 119,
            'total_per_sub' => 328,
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 12,
            'sk_nama' => 'Operability',
            'jml_res' => 119,
            'total_per_sub' => 397,
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 12,
            'sk_nama' => 'User Error Protection',
            'jml_res' => 119,
            'total_per_sub' => 360,
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 12,
            'sk_nama' => 'User Interface Aesthetics',
            'jml_res' => 119,
            'total_per_sub' => 333,
            'bobot_relatif' => 0.17
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 12,
            'sk_nama' => 'Accessibility',
            'jml_res' => 119,
            'total_per_sub' => 396,
            'bobot_relatif' => 0.17
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 13,
            'sk_nama' => 'Maturity',
            'jml_res' => 16,
            'total_per_sub' => 39,
            'bobot_relatif' => 0.19
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 13,
            'sk_nama' => 'Availability',
            'jml_res' => 119,
            'total_per_sub' => 383,           
            'bobot_relatif' => 0.33
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 13,
            'sk_nama' => 'Fault-Tolerance',
            'jml_res' => 16,
            'total_per_sub' => 41,           
            'bobot_relatif' => 0.24
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 13,
            'sk_nama' => 'Recoverability',
            'jml_res' => 119,
            'total_per_sub' => 369,
            'bobot_relatif' => 0.24
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 14,
            'sk_nama' => 'Confidentiality',
            'jml_res' => 16,
            'total_per_sub' => 57,
            'bobot_relatif' => 0.15
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 14,
            'sk_nama' => 'Integrity',
            'jml_res' => 16,
            'total_per_sub' => 62,
            'bobot_relatif' => 0.33
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 14,
            'sk_nama' => 'Non-repudiation',
            'jml_res' => 16,
            'total_per_sub' => 51,
            'bobot_relatif' => 0.11
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 14,
            'sk_nama' => 'Authenticity',
            'jml_res' => 16,
            'total_per_sub' => 52,
            'bobot_relatif' => 0.19
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 14,
            'sk_nama' => 'Accountability',
            'jml_res' => 16,
            'total_per_sub' => 29,
            'bobot_relatif' => 0.22
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 15,
            'sk_nama' => 'Modularity',
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 15,
            'sk_nama' => 'Reusability',
            'jml_res' => 16,
            'total_per_sub' => 46,
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 15,
            'sk_nama' => 'Analysability',
            'jml_res' => 16,
            'total_per_sub' => 50,
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 15,
            'sk_nama' => 'Modifiability',
            'jml_res' => 16,
            'total_per_sub' => 46,
            'bobot_relatif' => 0.20
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 15,
            'sk_nama' => 'Testability',
            'jml_res' => 16,
            'total_per_sub' => 49,
            'bobot_relatif' => 0.20
        ]);

        \App\SubKarakteristik::create([
            'k_id'  => 16,
            'sk_nama' => 'Adaptability',
            'jml_res' => 16,
            'total_per_sub' => 39,
            'bobot_relatif' => 0.25
        ]);
        \App\SubKarakteristik::create([
            'k_id'  => 16,
            'sk_nama' => 'Installability',
            'jml_res' => 16,
            'total_per_sub' => 45,
            'bobot_relatif' => 0.75
        ]);
    }
}
    