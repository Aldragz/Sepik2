<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');      // penerima
            $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete(); // aktor
            $table->enum('type', [
                'follow', 'like', 'comment', 'comment_like',
                'message', 'mention', 'story_view', 'system'
            ]);
            $table->json('data')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
