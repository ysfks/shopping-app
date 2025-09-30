<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique(); // ID from Fake Store API
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->decimal('price', 10, 2);
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->float('rating_rate')->nullable();
            $table->unsignedInteger('rating_count')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
