<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quantite_livre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('b_reception_id');
            $table->unsignedInteger('quantity');
            $table->timestamps();

            // Add foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('b_reception_id')->references('id')->on('b_receptions')->onDelete('cascade');
            
            // Correct the unique constraint
            $table->unique(['product_id', 'b_reception_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quantite_livre');
    }
};