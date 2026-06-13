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
        // Pivot table column is Pasutijuma_ID (not Pasutijumi_ID)
        return $this->belongsToMany(Pasutijums::class, 'PasutijumaMateriali', 'Materiali_ID', 'Pasutijuma_ID')
                    ->withPivot('Daudzums');
    }
 
    public function krajumi()
    {
        return $this->hasMany(FilialuKrajumi::class, 'Materiali_ID', 'Materiali_ID');
    }
}
