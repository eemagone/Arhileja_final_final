<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasutijums extends Model
{
    protected $table = 'Pasutijumi';
    
    // LABOTS: Bija 'Pasutijuma_ID', bet datubāzē ir 'Pasutijumi_ID'
    protected $primaryKey = 'Pasutijumi_ID'; 
    public $timestamps = false;

    // LABOTS: Izņemti Klienta_ID un Filiales_ID, jo to nav Pasutijumi tabulā
    protected $fillable = [
        'Apavu_ID', 'Meistara_ID', 
        'Pienemsanas_Datums', 'Termins', 'RemontaVeids', 
        'Statuss', 'Cena', 'Garantijas_Termins'
    ];

    public function apavi()
    {
        // LABOTS: Trešais parametrs tagad ir 'Apavi_ID'
        return $this->belongsTo(Apavi::class, 'Apavu_ID', 'Apavi_ID');
    }

    public function meistars()
    {
        return $this->belongsTo(Meistars::class, 'Meistara_ID', 'Meistari_ID');
    }

    public function atsauksme()
    {
        // Šeit atstājam Pasutijuma_ID, jo Atsauksmes tabulā ārējā atslēga ir Pasutijuma_ID
        return $this->hasOne(Atsauksme::class, 'Pasutijuma_ID', 'Pasutijumi_ID');
    }

    public function materiali()
    {
        // Šeit arī atstājam Pasutijuma_ID kā Pivot kolonnu
        return $this->belongsToMany(Materiali::class, 'PasutijumaMateriali', 'Pasutijuma_ID', 'Materiali_ID')
                    ->withPivot('Daudzums');
    }
}