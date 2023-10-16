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
            $table->integer('ein')->nullable()->change();
            $table->smallInteger('verify_ein')->default(1);
            $table->smallInteger('verify_business')->default(1);
            $table->smallInteger('verify_customer_review')->default(1);
            $table->json('business_address')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('business_banner')->nullable();
            $table->string('business_website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->text('about')->nullable();
            $table->string('bphone')->nullable();
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
            $table->integer('ein')->change();
            $table->dropColumn('verify_ein');
            $table->dropColumn('verify_business');
            $table->dropColumn('verify_customer_review');
            $table->dropColumn('business_address');
            $table->dropColumn('business_logo');
            $table->dropColumn('business_banner');
            $table->dropColumn('business_website');
            $table->dropColumn('facebook');
            $table->dropColumn('twitter');
            $table->dropColumn('instagram');
            $table->dropColumn('about');
            $table->dropColumn('bphone');
        });
    }
};
