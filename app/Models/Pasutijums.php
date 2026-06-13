<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasutijums extends Model
{
    protected $table = 'Pasutijumi';
    protected $primaryKey = 'Pasutijuma_ID';
    public $timestamps = false;

    protected $fillable = [
        'Klienta_ID', 'Filiales_ID', 'Apavu_ID', 'Meistara_ID', 
        'Pienemsanas_Datums', 'Izpildes_Termins', 'Apraksts', 
        'Statuss', 'Cena', 'Garantijas_Termins'
    ];

    public function klients()
    {
        return $this->belongsTo(Klients::class, 'Klienta_ID', 'Klienta_ID');
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class, 'Filiales_ID', 'Filiales_ID');
    }

    public function apavi()
    {
        return $this->belongsTo(Apavi::class, 'Apavu_ID', 'Apavu_ID');
    }

    public function meistars()
    {
        return $this->belongsTo(Meistars::class, 'Meistara_ID', 'Meistari_ID');
    }

    public function atsauksme()
    {
        return $this->hasOne(Atsauksme::class, 'Pasutijuma_ID', 'Pasutijuma_ID');
    }

    public function materiali()
    {
        return $this->belongsToMany(Materiali::class, 'PasutijumaMateriali', 'Pasutijuma_ID', 'Materiali_ID')
                    ->withPivot('Daudzums'); // Lai piekļūtu patērētajam skaitam
    }
}