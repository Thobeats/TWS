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
            $table->renameColumn('store_id', 'vendor_id');
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();
            $table->json('pics')->nullable();
            $table->string('description');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('products', ['sizes','colors','pics','description','status']);
        Schema::table('products', function(Blueprint $table){
            $table->renameColumn('vendor_id','store_id');
        });
    }
};
