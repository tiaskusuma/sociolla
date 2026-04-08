<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('shipping_address');
            $table->string('payment_method')->nullable()->after('payment_proof');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_proof', 'payment_method']);
        });
    }
};
