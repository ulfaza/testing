<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karakteristik extends Model
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primarykey = 'k_id';
    
    protected $fillable = [
        'k_nama', 'k_bobot',
    ];

    public function subkarakteristik()
    {
        return $this->hasMany(\App\SubKarakteristik::class);
    }

    public function penilaiankarakteristik()
    {
        return $this->hasMany(\App\PenilaianKarakteristik::class);
    }
}
