<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Klients extends Model
{
    protected $table = 'Klienti';
    protected $primaryKey = 'Klienti_ID';
    public $timestamps = false;
 
    protected $fillable = ['user_id', 'Vards', 'Uzvards', 'TelNr'];
 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
 
    public function apavi()
    {
        return $this->hasMany(Apavi::class, 'Klienta_ID', 'Klienti_ID');
    }
 
    public function pasutijumi()
    {
        return $this->hasManyThrough(
            Pasutijums::class,
            Apavi::class,
            'Klienta_ID',   // fk on Apavi table
            'Apavu_ID',     // fk on Pasutijumi table
            'Klienti_ID',   // pk on Klienti table
            'Apavi_ID'      // pk key on Apavi table
        );
    }
}
 