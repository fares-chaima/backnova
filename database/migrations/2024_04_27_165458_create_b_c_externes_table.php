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
        Schema::create('b_c_externes', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->unsignedBigInteger('fournisseur_id');
            $table->timestamps();
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade'); 
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_c_externes');
    }
};
