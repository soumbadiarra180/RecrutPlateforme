<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres_emploi', function (Blueprint $table) {
            $table->id('id_offre');
            $table->string('titre', 100);
            $table->text('description');
            $table->enum('type_contrat', ['CDI', 'CDD', 'Stage', 'Freelance']);
            $table->string('lieu', 100);
            $table->date('date_publication');
            $table->date('date_limite');
            $table->enum('statut', ['ouverte', 'fermee'])->default('ouverte');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offres_emploi');
    }
};