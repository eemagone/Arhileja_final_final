<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klients extends Model
{
    protected $table = 'Klienti';
    protected $primaryKey = 'Klienta_ID';
    public $timestamps = false;

    protected $fillable = ['user_id', 'Vards', 'Uzvards', 'TelNr'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function apavi()
    {
        return $this->hasMany(Apavi::class, 'Klienta_ID', 'Klienta_ID');
    }

    public function pasutijumi()
    {
        return $this->hasMany(Pasutijums::class, 'Klienta_ID', 'Klienta_ID');
    }
}