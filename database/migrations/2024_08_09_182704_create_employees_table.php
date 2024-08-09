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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('nik')->unique();
            $table->string('name');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);

            $table->string('ktp_number')->unique();
            $table->string('ktp_address');
            $table->string('ktp_zipcode');

            $table->enum('last_education', ['SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']);
            $table->string('last_education_major');
            $table->string('almamater');

            $table->enum('religion', ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Budha']);
            $table->enum('blood_type', ['A', 'B', 'O', 'AB']);

            $table->enum('marital_status', ['Lajang', 'Nikah', 'Janda', 'Duda']);
            $table->date('marriage_date')->nullable();
            $table->integer('children_count')->nullable();

            $table->enum('tax_status', ['TK0', 'TK1', 'TK2', 'TK3', 'K0', 'K1', 'K2', 'K3']);
            $table->string('npwp')->unique();
            $table->string('bpjs_tenaga_kerja')->unique();
            $table->string('bpjs_kesehatan')->unique();

            $table->string('current_address');
            $table->string('phone_number');
            $table->string('emergency_contact_number');

            $table->string('file_kk');
            $table->string('file_ktp');
            $table->string('file_npwp')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_akta_nikah')->nullable();
            $table->string('file_bpjs_kesehatan')->nullable();
            $table->string('file_bpjs_tenaga_kerja')->nullable();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
