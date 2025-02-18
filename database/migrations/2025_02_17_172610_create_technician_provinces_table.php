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
        Schema::create('technician_provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technician_id')->constrained('technicians')->onDelete('cascade');
            $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_provinces');
    }
};
