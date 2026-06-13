<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilialuKrajumi extends Model
{
    protected $table = 'FilialuKrajumi';
    protected $primaryKey = 'Krajuma_ID';
    public $timestamps = false;

    protected $fillable = ['Filiales_ID', 'Materiali_ID', 'Apjoms'];

    public function filiale()
    {
        return $this->belongsTo(Filiale::class, 'Filiales_ID', 'Filiales_ID');
    }

    public function materiali()
    {
        return $this->belongsTo(Materiali::class, 'Materiali_ID', 'Materiali_ID');
    }
}
