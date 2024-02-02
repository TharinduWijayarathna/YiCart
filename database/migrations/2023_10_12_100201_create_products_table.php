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
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('product_category_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('type')->nullable();
            $table->bigInteger('unit')->nullable();
            $table->decimal('cost',12,2)->nullable();
            $table->decimal('selling',12,2)->nullable();
            $table->boolean('status')->default(false);
            $table->text('introduction')->nullable();
            $table->decimal('cost',12,2)->default(0)->change();
            $table->decimal('selling',12,2)->default(0)->change();
            $table->decimal('stock_quantity', 15, 2)->nullable();
            $table->integer('product_type')->default(1);
            $table->bigInteger('image_id')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
