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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('status')->default(1);
            $table->bigInteger('channel_id')->default(0);
            $table->integer('product')->default(0);
            $table->integer('invoice')->default(0);
            $table->integer('supplier')->default(0);
            $table->integer('customer')->default(0);
            $table->integer('receipt')->default(0);
            $table->integer('voucher')->default(0);
            $table->integer('quotation')->default(0);
            $table->integer('transaction')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('report')->default(0);
            $table->integer('uom')->default(0);
            $table->integer('product_category')->default(0);
            $table->integer('invoice_parameters')->default(0);
            $table->integer('expenses_category')->default(0);
            $table->integer('business_configuration')->default(0);
            $table->integer('email_setting')->default(0);
            $table->integer('accounts')->default(0);
            $table->integer('tax_registry')->default(0);
            $table->integer('user_registry')->default(0);
            $table->decimal('commission', 10, 2)->default(0);
            $table->bigInteger('plan_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
