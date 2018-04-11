<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CredencialesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credenciales', function(blueprint $table){
            $table->integer('sitio_id')->unsigned();
            $table->integer('marca_id')->unsigned();
            $table->integer('tcredencial_id')->unsigned();
            $table->string('valor');
            $table->timestamps();

            $table->primary(['sitio_id', 'marca_id', 'tcredencial_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credenciales');
    }
}
