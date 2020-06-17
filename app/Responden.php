<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primarykey = 'r_id';
    
    protected $fillable = [
        'r_nama', 
    ];

    public function hasilkuesioner()
    {
        return $this->hasMany(\App\HasilKuesioner::class);
    }
}
