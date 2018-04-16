<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_class', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->unique(['school_id', 'class_id']);
            $table->foreign('school_id')
                    ->references('id')
                    ->on('schools')
                    ->onDelete('cascade');
            $table->foreign('class_id')
                    ->references('id')
                    ->on('eportal_classes')
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
        Schema::dropIfExists('school_class');
    }
}
