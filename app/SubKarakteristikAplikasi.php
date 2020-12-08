<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class SubKarakteristikAplikasi extends Model
{
    use Notifiable;
    protected $table = 'subkarakteristikaplikasi';
    protected $primarykey = 'sa_id';
    
    protected $fillable = [
    	'sa_nama', 'sa_bobot',
        'bobot_absolut', 'nilai_subfaktor', 'nilai_absolut',
    ];

    public function subkarakteristik()
    {
        return $this->belongsTo(\App\SubKarakteristik::class,'sk_id');
    }

	public function karakteristikaplikasi()
    {
        return $this->belongsTo(\App\KarakteristikAplikasi::class,'ka_id');
    }

    public function hasilkuesioner()
    {
        return $this->hasMany(\App\HasilKuesioner::class);
    }
}
