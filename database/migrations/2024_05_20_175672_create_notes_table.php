<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->string('text');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('visibility_id')->constrained('visibilities');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
