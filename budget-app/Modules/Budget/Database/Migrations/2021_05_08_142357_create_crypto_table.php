<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->double('amount');
            $table->double('paid');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->date('date')->nullable();
            $table->longtext('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto');
    }
}
