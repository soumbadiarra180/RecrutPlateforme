<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_candidature';

    protected $fillable = [
        'id_candidat',
        'id_offre',
        'lettre_motivation',
        'statut',
        'motif_decision',
        'date_candidature',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id_candidat');
    }

    public function offre()
    {
        return $this->belongsTo(OffreEmploi::class, 'id_offre', 'id_offre');
    }
}