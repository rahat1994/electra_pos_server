<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('purchases', function (Blueprint $table) {
            //
            $table->double("total_cost")->nullable()->after('product_variety_count');
            $table->double("quantity")->nullable()->after('product_variety_count');


            $table->string("status")->nullable()->change();
            $table->string("payment_status")->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('purchases', function (Blueprint $table) {
            //
            $table->dropColumn(['quantity', 'total_cost']);

            $table->integer("status")->nullable($value = false)->change();
            $table->integer("payment_status")->nullable($value = false)->change();
        });

    }
}
