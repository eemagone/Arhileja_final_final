<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meistars extends Model
{
    protected $table = 'Meistari';
    protected $primaryKey = 'Meistari_ID';
    public $timestamps = false;

    protected $fillable = ['Filiales_ID', 'user_id', 'Vards', 'Uzvards', 'TelNr'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class, 'Filiales_ID', 'Filiales_ID');
    }

    public function pasutijumi()
    {
        return $this->hasMany(Pasutijums::class, 'Meistara_ID', 'Meistari_ID');
    }
}