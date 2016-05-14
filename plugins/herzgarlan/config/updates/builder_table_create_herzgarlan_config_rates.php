<?php namespace HerzGarlan\Config\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanConfigRates extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_config_rates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('slug');
            $table->string('name');
            $table->decimal('value', 10, 2)->default(0.00);
            $table->text('short_description')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->integer('updated_by');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_config_rates');
    }
}
