<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenilaianKarakteristik extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primarykey = 'pk_id';
    
    protected $fillable = [
        'pk_nilai',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	public function aplikasi()
    {
        return $this->belongsTo(\App\Aplikasi::class,'a_id');
    }

	public function karakteristik()
    {
        return $this->belongsTo(\App\Karakteristik::class,'k_id');
    }

    public function penilaiansubkarakteristik()
    {
        return $this->hasMany(\App\PenilaianSubKarakteristik::class);
    }
}
