<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass', function (Blueprint $table) {
            $table->increments('id');
            $table->string('observation')->nullable();;
            $table->timestamp('received_at')->nullable();

            // expediente - objeto de la presente tabla
            $table->integer('expedient_id')->unsigned();
            $table->foreign('expedient_id')->references('id')->on('expedients')->onDelete('cascade');

            // usuario que recive el expediente
            $table->integer('user_receiver_id')->unsigned();
            $table->foreign('user_receiver_id')->references('id')->on('users')->onDelete('cascade');

            // usuario que remite el expediente
            $table->integer('user_sender_id')->unsigned();
            $table->foreign('user_sender_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('pass');
    }
}
