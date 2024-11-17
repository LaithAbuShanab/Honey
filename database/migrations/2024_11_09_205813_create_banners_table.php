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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique();
            $table->boolean('is_active')->default(false);
            $table->json('title');
            $table->json('text')->nullable();
            $table->json('button_text')->nullable();
            $table->enum('alignments', ['left', 'center', 'right'])->default('left');
            $table->string('button_link')->nullable();
            $table->integer('sort');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
