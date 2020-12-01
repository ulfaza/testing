<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianSubKarakteristik extends Model
{
    protected $primarykey = 'ps_id';
    
    protected $fillable = [
        'jml_reponden', 'total_per_sub', 
        'bobot_absolut', 'nilai_subfaktor', 'nilai_absolut',
    ];

    public function subkarakteristik()
    {
        return $this->belongsTo(\App\SubKarakteristik::class,'sk_id');
    }

	public function penilaiankarakteristik()
    {
        return $this->belongsTo(\App\PenilaianKarakteristik::class,'pk_id');
    }

}
