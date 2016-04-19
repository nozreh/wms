<?php namespace HerzGarlan\Config\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanConfigBlockedDates extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_config_blocked_dates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->text('remarks');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_config_blocked_dates');
    }
}
