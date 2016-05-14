<?php namespace HerzGarlan\Config\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanConfigCustomerRate extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_config_customer_rate', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('rate_id')->unsigned();
            $table->decimal('value', 4, 2);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_config_customer_rate');
    }
}
