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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('grn_code')->nullable();
            $table->bigInteger('product_id');
            $table->bigInteger('grn_id')->nullable();
            $table->string('name')->nullable();
            $table->string('barcode')->nullable();
            $table->bigInteger('uom')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->bigInteger('status')->default(0);
            $table->bigInteger('created_by_id')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
