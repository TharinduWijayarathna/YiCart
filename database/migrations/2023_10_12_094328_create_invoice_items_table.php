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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->integer('position')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->integer('discount_type')->default(1);
            $table->text('introduction')->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->string('name')->nullable();
            $table->integer('discount_value')->nullable();
            $table->integer('outstanding_status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
