<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Apavi extends Model
{
    protected $table = 'Apavi';
    protected $primaryKey = 'Apavi_ID';
    public $timestamps = false;
 
    protected $fillable = ['Klienta_ID', 'Zimols', 'Tips', 'ApavuMaterials'];
 
    public function klients()
    {
        return $this->belongsTo(Klients::class, 'Klienta_ID', 'Klienti_ID');
    }
 
    public function pasutijumi()
    {
        return $this->hasMany(Pasutijums::class, 'Apavu_ID', 'Apavi_ID');
    }
}
