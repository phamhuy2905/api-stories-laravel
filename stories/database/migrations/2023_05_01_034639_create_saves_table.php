<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('saves', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->foreignId('story_id')->constrained('stories');
            $table->foreignId('chaper_id')->constrained('chapers');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('isDeleted')->default(0);
            $table->primary(['story_id','user_id']);
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('saves');
    }
};
