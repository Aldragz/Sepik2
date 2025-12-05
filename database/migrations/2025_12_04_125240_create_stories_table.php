<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->dateTime('expires_at');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
