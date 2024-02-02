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
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by')->nullable();
            $table->string('customer_type')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('code')->nullable();
            $table->integer('status')->default(0);
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->integer('discount_type')->nullable();
            $table->bigInteger('sales_person_id')->nullable();
            $table->decimal('customer_paid', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->integer('is_return')->default(0);
            $table->string('remark')->nullable();
            $table->integer('credit_status')->default(0);
            $table->string('discount_remark')->nullable();
            $table->integer('payment_type')->nullable();
            $table->decimal('total_tax', 15, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_orders');
    }
};
