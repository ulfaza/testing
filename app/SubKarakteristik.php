<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKarakteristik extends Model
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primarykey = 'sk_id';
    
    protected $fillable = [
        'sk_nama', 'bobot_relatif',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	public function karakteristik()
    {
        return $this->belongsTo(\App\Karakteristik::class,'k_id');
    }
}
