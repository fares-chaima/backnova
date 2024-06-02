<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b_sortie_b_c_interne', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('b_sortie_id');
        $table->unsignedBigInteger('b_c_interne_id');
        // Ajoutez d'autres colonnes au besoin

        // Clés étrangères
        $table->foreign('b_sortie_id')->references('id')->on('b_sorties')->onDelete('cascade');
        $table->foreign('b_c_interne_id')->references('id')->on('b_c_internes')->onDelete('cascade');

        // Index unique pour empêcher les doublons
        $table->unique(['b_sortie_id', 'b_c_interne_id']);
        });
    }          

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_sortie_b_c_interne');
    }
};
