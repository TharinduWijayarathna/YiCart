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
        Schema::create('receipt_refunds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->nullable();
            $table->string('invoice_code')->nullable();
            $table->bigInteger('receipt_id')->nullable();
            $table->string('receipt_code')->nullable();
            $table->bigInteger('refund_amount')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status')->default(0);
            $table->integer('refund_status')->default(0);
            $table->integer('confirm_status')->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_refunds');
    }
};
