<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category'); // egrek, dodos, telescopic_pole
            $table->text('description');
            $table->text('specifications')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->string('unit')->default('pcs'); // pcs, set, meter
            $table->string('image')->nullable();
            $table->string('weight')->nullable(); // berat produk (kg)
            $table->string('material')->nullable(); // bahan material
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
