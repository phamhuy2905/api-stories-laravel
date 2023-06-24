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
        Schema::create('likes', function (Blueprint $table) {
            $table->foreignId('story_id')->constrained('stories');
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->enum('type', ['Like', 'Love', 'Care', 'Haha','Wow','Sad','Angry'])->default('Like');
            $table->primary(['story_id','user_id']);
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
