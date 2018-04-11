<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MarcaSitioMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marca_sitio', function(Blueprint $table){
            $table->integer('marca_id')->unsigned();
            $table->integer('sitio_id')->unsigned();

            $table->primary(['marca_id', 'sitio_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marca_sitio');
    }
}
