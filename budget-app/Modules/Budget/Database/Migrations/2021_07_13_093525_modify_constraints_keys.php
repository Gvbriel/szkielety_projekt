<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConstraintsKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign('cards_owner_id_foreign');
        });
        Schema::table('crypto', function (Blueprint $table) {
            $table->dropForeign('crypto_user_id_foreign');
        });
        Schema::table('stock', function (Blueprint $table) {
            $table->dropForeign('stock_user_id_foreign');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign('budgets_card_id_foreign');
            $table->dropForeign('budgets_user_id_foreign');
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
