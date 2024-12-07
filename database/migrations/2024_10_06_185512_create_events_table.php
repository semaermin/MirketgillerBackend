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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->foreignId('author_id')->constrained()->onDelete('cascade')->nullable;
            $table->timestamps(); // This creates created_at and updated_at
            $table->timestamp('published_at')->nullable();
            $table->boolean('status')->default(false);
            $table->json('event_paths')->nullable();
            $table->enum('event_type', ['hackathon', 'ideathon', 'workshop', 'seminar', 'conference', 'webinar', 'meetup', 'bootcamp', 'networking', 'competition']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
