<?php

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class);
            $table->bigInteger('expense_category_id')->nullable();
            $table->bigInteger('expense_sub_category_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->text('remark')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('amount',12,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_costs');
    }
};
