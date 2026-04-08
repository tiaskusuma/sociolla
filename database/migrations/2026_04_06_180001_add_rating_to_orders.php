<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_rated')->default(false);
            $table->text('rating_review')->nullable();
            $table->string('rating_image')->nullable();
            $table->integer('rating_stars')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['is_rated', 'rating_review', 'rating_image', 'rating_stars']);
        });
    }
};
