<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['candidat', 'recruteur'])->default('candidat')->after('email');
            $table->foreignId('id_candidat')->nullable()->after('role')->constrained('candidats', 'id_candidat')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_candidat']);
            $table->dropColumn(['role', 'id_candidat']);
        });
    }
};