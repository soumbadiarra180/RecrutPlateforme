<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id('id_candidature');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_offre')->constrained('offres_emploi', 'id_offre')->onDelete('cascade');
            $table->text('lettre_motivation')->nullable();
            $table->enum('statut', ['recue', 'en_cours_examen', 'entretien', 'acceptee', 'refusee'])->default('recue');
            $table->text('motif_decision')->nullable();
            $table->date('date_candidature');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};