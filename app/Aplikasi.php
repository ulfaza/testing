<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    //
    use Notifiable;
    protected $table = 'aplikasi';
    protected $primaryKey = 'a_id';
    
    protected $fillable = [
        'a_nama', 'a_url', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	public function user()
    {
        return $this->belongsTo(\App\User::class,'id');
    }

    public function karakteristikaplikasi()
    {
        return $this->hasMany(\App\KarakteristikAplikasi::class);
    }
}
