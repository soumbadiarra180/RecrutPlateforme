<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offres_emploi', function (Blueprint $table) {
            $table->text('missions')->nullable()->after('description');
            $table->text('competences')->nullable()->after('missions');
            $table->text('profil_recherche')->nullable()->after('competences');
        });
    }

    public function down(): void
    {
        Schema::table('offres_emploi', function (Blueprint $table) {
            $table->dropColumn(['missions', 'competences', 'profil_recherche']);
        });
    }
};