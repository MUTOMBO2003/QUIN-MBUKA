<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 10)->nullable()->unique(); // Pour admin/secretaire
            $table->string('nom')->nullable();
            $table->string('postnom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('email')->nullable()->unique(); // Pour client
            $table->string('password')->nullable();
            $table->enum('role', ['admin', 'secretaire', 'client']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};