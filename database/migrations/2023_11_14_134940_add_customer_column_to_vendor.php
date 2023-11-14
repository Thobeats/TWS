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
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('stripe_customer');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->json('stripe_customer_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table){
            $table->json('stripe_customer')->nullable();
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('stripe_customer_details');
        });
    }
};
