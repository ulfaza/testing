<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class KarakteristikAplikasi extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'karakteristikaplikasi';
    protected $primarykey = 'ka_id';
    
    protected $fillable = [
        'ka_nama', 'ka_bobot', 
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

    public function subkarakteristikaplikasi()
    {
        return $this->hasMany(\App\SubKarakteristikAplikasi::class);
    }
}
