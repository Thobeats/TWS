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
        Schema::table("carts", function (Blueprint $table) {
            $table->dropColumn("items");

            $table->bigInteger("vendor_id")->nullable();
            $table->bigInteger("product_id")->nullable();
            $table->string("quantity")->nullable();
            $table->string("price")->nullable();
            $table->string("color")->nullable();
            $table->string("size")->nullable();
            $table->string("shipping_fee")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("carts", function (Blueprint $table) {
            $table->json("items")->nullable();

            $table->dropColumn("vendor_id");
            $table->dropColumn("product_id");
            $table->dropColumn("quantity");
            $table->dropColumn("price");
            $table->dropColumn("color");
            $table->dropColumn("size");
            $table->dropColumn("shipping_fee");
        });
    }
};
