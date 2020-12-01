<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PenilaianSubKarakteristik extends Model
{
    use Notifiable;
    protected $table = 'penilaiansubkarakteristik';
    protected $primarykey = 'ps_id';
    
    protected $fillable = [
        'jml_responden', 'total_per_sub', 
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
