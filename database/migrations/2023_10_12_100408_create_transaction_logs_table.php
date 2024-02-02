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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->nullable();
            $table->string('invoice_code')->nullable();
            $table->bigInteger('voucher_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('title')->nullable();
            $table->decimal('amount',12,2)->default(0);
            $table->bigInteger('method')->nullable();
            $table->date('date')->nullable();
            $table->string('cheque_no')->nullable();
            $table->bigInteger('card_no')->nullable();
            $table->bigInteger('bank_account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->date('post_date')->nullable();
            $table->string('remark')->nullable();
            $table->bigInteger('type')->nullable();
            $table->bigInteger('customer_account_no')->nullable();
            $table->bigInteger('supplier_account_no')->nullable();
            $table->integer('receipt_id')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('balance')->nullable();
            $table->string('tr_code')->nullable();
            $table->bigInteger('user_bank_id')->nullable();
            $table->string('user_bank_acc')->nullable();
            $table->string('receipt_code')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('customer_company')->nullable();
            $table->string('supplier_company')->nullable();
            $table->integer('refund_status')->default(0);
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
        Schema::dropIfExists('transaction_logs');
    }
};
