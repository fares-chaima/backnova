<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('article_product', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('article_id');
        $table->unsignedBigInteger('product_id');
        // You can add additional columns if needed
        $table->timestamps();

        // Define foreign key constraints
        $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_product');
    }
};
