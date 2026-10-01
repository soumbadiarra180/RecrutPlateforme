<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_candidature')->nullable()->constrained('candidatures', 'id_candidature')->onDelete('cascade');
            $table->string('titre', 150);
            $table->text('message');
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};