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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quotation_id')->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('template_id')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->text('remark')->nullable();
            $table->string('ref_no')->nullable();
            $table->decimal('sub_total',12,2)->nullable();
            $table->decimal('discount',12,2)->nullable();
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('other_discount', 10, 2)->default(0);
            $table->decimal('total',12,2)->nullable();
            $table->string('attention_name')->nullable();
            $table->string('attention_address')->nullable();
            $table->boolean('is_scheduled')->default(false);
            $table->integer('schedule_count')->default(1);
            $table->date('schedule_date')->nullable();
            $table->integer('schedule_type')->default(1);
            $table->integer('status')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('customer_company')->nullable();
            $table->integer('discount_type')->nullable();
            $table->decimal('discount_value',12,2)->default(0)->nullable();
            $table->integer('pay_status')->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('temp_paid_amount', 15, 2)->default(0);
            $table->decimal('due_amount', 15, 2)->default(0);
            $table->decimal('temp_due_amount', 15, 2)->default(0);
            $table->text('invoice_parameters')->nullable();
            $table->integer('outstanding_status')->default(0);
            $table->string("url_key")->nullable();
            $table->timestamp("url_first_view_at")->nullable();
            $table->timestamp("url_last_view_at")->nullable();
            $table->integer("url_view_count")->default(0);
            $table->decimal('refund_amount',12,2)->default(0);
            $table->decimal('temp_refund_amount',12,2)->default(0);
            $table->string('invoice_link')->nullable();
            $table->integer('recurring_option')->default(0);
            $table->integer('recurring_date')->nullable();
            $table->date('recurring_till')->nullable();
            $table->integer('recurring_invoice')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
