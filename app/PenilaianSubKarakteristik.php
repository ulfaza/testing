<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianSubKarakteristik extends Model
{
    protected $primarykey = 'ps_id';
    
    protected $fillable = [
        'ps_bobot_relatif', 'ps_nilai',
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
