<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->decimal('price', 12, 2);
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade');
            $table->boolean('in_stock')->default(true)->index();
            $table->float('rating', 3, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
