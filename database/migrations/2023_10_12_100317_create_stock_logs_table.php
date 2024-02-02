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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->string('grn_code')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('quantity', 15, 2)->nullable();
            $table->string('reason')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('type')->nullable();
            $table->bigInteger('invoice_id')->nullable();
            $table->bigInteger('Pos_invoice_id')->nullable();
            $table->decimal('cost', 15, 2)->default(0)->nullable();
            $table->decimal('selling_price', 15, 2)->default(0)->nullable();
            $table->string('po_number')->nullable();
            $table->bigInteger('transaction_type_id')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
