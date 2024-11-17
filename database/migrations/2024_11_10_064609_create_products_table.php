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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->json('name');
            $table->json('description')->nullable();
            $table->string('slug', 255)->unique();
            $table->integer('sort');
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('cost_price')->nullable();
            $table->decimal('rate')->default(0);
            $table->integer('rate_counter')->default(0);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
