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
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->enum('status', ['active', 'waiting', 'closed'])->default('active');
            $table->timestamp('last_activity')->useCurrent();
            $table->timestamps();
            
            $table->index(['status', 'last_activity']);
            $table->index('session_id');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('message');
            $table->boolean('is_from_user')->default(true);
            $table->boolean('is_read')->default(false);
            $table->json('metadata')->nullable(); // For storing additional data like quick actions, etc.
            $table->timestamps();
            
            $table->index(['chat_session_id', 'created_at']);
            $table->index(['is_read', 'is_from_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_sessions');
    }
};