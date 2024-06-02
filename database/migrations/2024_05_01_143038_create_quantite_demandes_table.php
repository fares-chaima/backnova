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
        Schema::create('quantite_demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('b_c_interne_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('b_c_interne_id')->references('id')->on('b_c_internes')->onDelete('cascade');
            $table->unique(['product_id', 'b_c_interne_id']);

            $table->unsignedInteger('quantity'); 
            }); 
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
