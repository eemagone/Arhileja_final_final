<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiali extends Model
{
    protected $table = 'Materiali';
    protected $primaryKey = 'Materiali_ID';
    public $timestamps = false;

    protected $fillable = ['Nosaukums', 'Mervieniba', 'Cena'];

    public function pasutijumi()
    {
        return $this->belongsToMany(Pasutijums::class, 'PasutijumaMateriali', 'Materiali_ID', 'Pasutijuma_ID')
                    ->withPivot('Daudzums');
    }
}