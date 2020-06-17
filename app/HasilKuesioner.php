<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilKuesioner extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'hk_nilai', 
    ];

	public function responden()
    {
        return $this->belongsTo(\App\Responden::class,'r_id');
    }

	public function penilaiansubkarakteristik()
    {
        return $this->belongsTo(\App\PenilaianSubKarakteristik::class,'ps_id');
    }
}
