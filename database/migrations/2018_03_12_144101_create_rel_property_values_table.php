<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelPropertyValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_property_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_value');
            $table->unsignedInteger('parent')->nullable();
            $table->unique(['property_value', 'parent']);
            $table->foreign('property_value')
                ->references('id')
                ->on('property_values')
                ->onDelete('cascade');
            $table->foreign('parent')
                ->references('id')
                ->on('rel_property_values')
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
        Schema::dropIfExists('rel_property_values');
    }
}
