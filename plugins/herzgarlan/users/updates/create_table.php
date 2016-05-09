<?php namespace HerzGarlan\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTable extends Migration
{

    public function up()
    {

        Schema::create('herzgarlan_users_drivers', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('contact_no');
            $table->string('email')->nullable();
            $table->string('fin')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('herzgarlan_users_drivers');
    }

}
