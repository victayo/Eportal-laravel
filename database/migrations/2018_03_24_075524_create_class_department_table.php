<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_department', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_class_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->unique(['school_class_id', 'department_id']);
            $table->foreign('school_class_id')
                    ->references('id')
                    ->on('school_class')
                    ->onDelete('cascade');
            $table->foreign('department_id')
                    ->references('id')
                    ->on('departments')
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
        Schema::dropIfExists('class_department');
    }
}
