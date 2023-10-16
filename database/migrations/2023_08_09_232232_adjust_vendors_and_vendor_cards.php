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
        Schema::table('vendors', function(Blueprint $table){
            $table->string('proof_of_bus')->change();
            $table->string('customer_review')->change();
        });

        Schema::table('vendor_cards', function(Blueprint $table){
            $table->string('external_account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function(Blueprint $table){
            $table->json('proof_of_bus')->change();
            $table->json('customer_review')->change();
        });

        Schema::table('vendor_cards', function(Blueprint $table){
            $table->dropColumn('external_account');
        });
    }
};
