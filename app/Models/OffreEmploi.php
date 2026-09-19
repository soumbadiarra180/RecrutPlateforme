<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreEmploi extends Model
{
    use HasFactory;

    protected $table = 'offres_emploi';
    protected $primaryKey = 'id_offre';

    protected $fillable = [
        'titre',
        'description',
        'type_contrat',
        'lieu',
        'date_publication',
        'date_limite',
        'statut',
    ];

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_offre', 'id_offre');
    }
}