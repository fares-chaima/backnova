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
        Schema::create('b_decharge_b_c_interne', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('b_decharge_id');
            $table->unsignedBigInteger('b_c_interne_id');
            
            $table->foreign('b_decharge_id')->references('id')->on('b_decharges')->onDelete('cascade');
            $table->foreign('b_c_interne_id')->references('id')->on('b_c_internes')->onDelete('cascade');
    
            $table->unique(['b_decharge_id', 'b_c_interne_id']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
