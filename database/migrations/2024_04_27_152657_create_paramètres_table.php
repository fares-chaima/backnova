<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\paramètre;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paramètres', function (Blueprint $table) {
            $table->id();
            $table->string('Dénomination');
            $table->integer('Code_Gestionnaire');
            $table->string('adresse');
            $table->integer('Téléphone');
            $table->string('photo_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paramètres');
    }
};
