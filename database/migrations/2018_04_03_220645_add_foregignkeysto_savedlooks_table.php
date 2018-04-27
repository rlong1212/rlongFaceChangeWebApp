<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForegignkeystoSavedlooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('savedlooks', function (Blueprint $table) {
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('noseID')->references('id')->on('noses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('savedlooks', function (Blueprint $table) {
            //
        });
    }
}
