<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Karakteristik extends Model
{
    use Notifiable;
    protected $table = 'karakteristik';
    protected $primaryKey = 'k_id';


    public $incrementing = true;    
    public $timestamps = false;

    protected $fillable = [
        'k_nama', 'k_bobot',
    ];

    public function subkarakteristik()
    {
        return $this->hasMany(\App\SubKarakteristik::class);
    }

    public function karakteristikaplikasi()
    {
        return $this->hasMany(\App\KarakteristikAplikasi::class);
    }
}
