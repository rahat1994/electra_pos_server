<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePurchasesTable extends Migration
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
            $table->dropColumn(['quantity', 'total_cost']);
            // $table->double("quantity")->nullable();
            // $table->double("total_cost")->nullable();

            // $table->string("status")->nullable()->change();
            // $table->string("payment_status")->nullable()->change();
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
    }
}
