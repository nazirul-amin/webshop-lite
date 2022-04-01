<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->references('id')->on('product_categories')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('sub_category_id')->nullable();

            $table->foreign('sub_category_id')->references('id')->on('sub_product_categories')->onUpdate('cascade')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign('category_id');
            $table->dropForeign('sub_category_id');
        });
    }
};
