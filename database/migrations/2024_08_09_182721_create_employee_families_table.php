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
        Schema::create('employee_families', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->date('birthdate');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('relation', ['Ibu', 'Ayah', 'Ibu Mertua', 'Ayah Mertua', 'Pasangan', 'Anak']);
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('file_bpjs_kesehatan')->nullable();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_families');
    }
};
