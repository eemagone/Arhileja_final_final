<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Atsauksme extends Model
{
    protected $table = 'Atsauksmes';
    protected $primaryKey = 'Atsauksmes_ID';
    public $timestamps = false;
 
    protected $fillable = ['Pasutijuma_ID', 'Vertejums', 'Komentars'];
 
    public function pasutijums()
    {
        return $this->belongsTo(Pasutijums::class, 'Pasutijuma_ID', 'Pasutijumi_ID');
    }
}
 