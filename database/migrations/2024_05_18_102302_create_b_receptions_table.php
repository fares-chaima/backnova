<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('b_receptions', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->unsignedBigInteger('b_c_externe_id');
            $table->unsignedBigInteger('fournisseur_id');
            $table->timestamps();

            $table->foreign('b_c_externe_id')->references('id')->on('b_c_externes')->onDelete('cascade');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('b_receptions');
    }
};
