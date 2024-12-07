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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // name alanı
            $table->string('link');  // link alanı (url)
            $table->text('desc');  // desc alanı
            $table->string('image');  // image alanı, dosya yolu
            $table->boolean('status')->default(true);  // status alanı
            $table->timestamps();  // created_at ve updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
