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
        Schema::create('b_c_internes', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->integer('status')->default(0); 
            $table->boolean('type');
            $table->string('observation')->default(null);
            $table->boolean('Recovery')->default(false);
            $table->unsignedBigInteger('user_id');
           $table->timestamps();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_c_internes');
    }
};
