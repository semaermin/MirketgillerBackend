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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 255);
            $table->string('logo_url', 500);
            $table->string('alt_text', 255);
            $table->enum('partner_type', ['sponsor', 'supporter']);
            $table->string('image')->nullable();
            $table->boolean('status')->default(false); // Boolean status alanı
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
