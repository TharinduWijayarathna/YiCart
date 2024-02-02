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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->nullable();
            $table->decimal('amount',12,2)->nullable();
            $table->date('date')->nullable();
            $table->integer('status')->default(0);
            $table->integer('type')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->date('post_date')->nullable();
            $table->string('ref_num')->nullable();
            $table->string('cheque_num')->nullable();
            $table->bigInteger('template_id')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('bank_id')->nullable();
            $table->integer('user_bank_id')->nullable();
            $table->string('user_bank_acc')->nullable();
            $table->string('remarks')->nullable();
            $table->string('account_no')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('customer_company')->nullable();
            $table->bigInteger('refund_status')->default(0);
            $table->bigInteger('refund_customer_id')->nullable();
            $table->string('refund_customer_name')->nullable();
            $table->string('refund_company_name')->nullable();
            $table->date('refund_date')->nullable();
            $table->bigInteger('refund_type')->nullable();
            $table->bigInteger('refund_user_bank_id')->nullable();
            $table->string('refund_user_bank_acc')->nullable();
            $table->integer('receipt_status')->default(0);
            $table->bigInteger('refund_invoice_status')->default(0);
            $table->bigInteger('refund_confirm_status')->default(0);
            $table->string('refund_remarks')->nullable();
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
        Schema::dropIfExists('receipts');
    }
};
