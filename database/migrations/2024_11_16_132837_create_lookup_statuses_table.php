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
        Schema::create('lookup_statuses', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug', 255)->unique();
            $table->integer('sort');
            $table->boolean('is_active')->default(true);
            $table->string('bg_color', 255)->nullable();
            $table->string('font_color', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lookup_statuses');
    }
};
