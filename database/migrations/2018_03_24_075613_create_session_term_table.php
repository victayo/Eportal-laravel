<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTermTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_term', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->integer('term_id')->unsigned();
            $table->unique(['session_id', 'term_id']);
            $table->foreign('term_id')
                    ->references('id')
                    ->on('terms')
                    ->onDelete('cascade');
            $table->foreign('session_id')
                    ->references('id')
                    ->on('sessions')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('session_term');
    }
}
