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
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('address');
            $table->text('about');
            $table->string('image');
           $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
           $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade');
           $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('status')->default(0);
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
