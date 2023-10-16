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
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign(['category_id']);
          //  $table->json('category_id')->change();
            $table->boolean('ready_to_ship')->nullable();
            $table->renameColumn('status', 'publish_status');
            $table->integer('shipping_type')->nullable();
            $table->string('shipping_fee')->nullable();
            $table->json('section_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('products', ['section_id','shipping_fee', 'shipping_type','ready_to_ship']);
        Schema::table('products', function(Blueprint $table){

            $table->integer('category_id')->change();
            $table->renameColumn('publish_status', 'status');
        });
    }
};
