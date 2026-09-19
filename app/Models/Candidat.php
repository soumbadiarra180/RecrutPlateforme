<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_candidat';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'cv',
    ];

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_candidat', 'id_candidat');
    }
}