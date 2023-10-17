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
      Schema::dropColumns("products", ["shipping_type","ready_to_ship", "no_in_stock", "sizes", "colors"]);

        Schema::table('products', function(Blueprint $table){
            $table->json('item_listing')->nullable();
            $table->string('sku')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table){
            $table->dropColumn('item_listing');
            $table->integer('shipping_type');
            $table->boolean('ready_to_ship');
            $table->integer('no_in_stock');
            $table->json('sizes');
            $table->json('colors');

        });
    }
};
