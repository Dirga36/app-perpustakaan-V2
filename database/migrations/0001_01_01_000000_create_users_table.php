<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Tabel Users dan Authentication
 *
 * Membuat tiga tabel untuk sistem autentikasi Laravel:
 * 1. users - Akun user aplikasi
 * 2. password_reset_tokens - Token sementara untuk fungsi reset password
 * 3. sessions - Penyimpanan session berbasis database
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel users utama untuk akun yang terautentikasi
        Schema::create('users', function (Blueprint $table) {
            $table->id();                                       // Primary key auto-increment
            $table->string('name');                             // Nama lengkap user
            $table->string('email')->unique();                  // Alamat email (unik, digunakan untuk login)
            $table->timestamp('email_verified_at')->nullable(); // Timestamp verifikasi email
            $table->string('password');                         // Password yang di-hash
            $table->rememberToken();                            // Token untuk fungsi "ingat saya"
            $table->timestamps();                               // created_at dan updated_at
            $table->softDeletes();                              // deleted_at untuk soft deletion
        });

        // Tabel password reset tokens untuk fungsi lupa password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();   // Email sebagai primary key
            $table->string('token');              // Hash token reset
            $table->timestamp('created_at')->nullable(); // Waktu pembuatan token
        });

        // Tabel sessions untuk manajemen session berbasis database
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();              // Session ID sebagai primary key
            $table->foreignId('user_id')->nullable()->index(); // User ID (nullable untuk tamu)
            $table->string('ip_address', 45)->nullable(); // Alamat IPv4 atau IPv6
            $table->text('user_agent')->nullable();       // Informasi browser/client
            $table->longText('payload');                  // Data session yang di-serialize
            $table->integer('last_activity')->index();    // Unix timestamp aktivitas terakhir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
