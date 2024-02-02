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
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id');
            $table->integer('type')->nullable();
            $table->integer('recurring_month')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->integer('pay_method')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('bank')->nullable();
            $table->date('post_date')->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('template_id')->nullable();
            $table->bigInteger('card_no')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
