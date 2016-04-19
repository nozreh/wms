<?php namespace HerzGarlan\Config\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanConfigTimeslots extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_config_timeslots', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->smallInteger('day')->unsigned();
            $table->json('timeslot');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_config_timeslots');
    }
}
