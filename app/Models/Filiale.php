<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiale extends Model
{
    protected $table = 'Filiales';
    protected $primaryKey = 'Filiales_ID';
    public $timestamps = false; 

    protected $fillable = ['Nosaukums', 'Adrese', 'Pilseta'];

    public function meistari()
    {
        return $this->hasMany(Meistars::class, 'Filiales_ID', 'Filiales_ID');
    }

    public function pasutijumi()
    {
        return $this->hasMany(Pasutijums::class, 'Filiales_ID', 'Filiales_ID');
    }
}