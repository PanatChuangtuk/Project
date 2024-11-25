<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('name');
            $table->string('sku');
            $table->string('size');
            $table->string('model');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('amount', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('shipping_free', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
