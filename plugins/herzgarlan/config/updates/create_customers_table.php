<?php namespace HerzGarlan\Config\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCustomersTable extends Migration
{

    public function up()
    {
        Schema::create('herzgarlan_config_customers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::create('herzgarlan_config_customers_rates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('customer_id')->unsigned();
            $table->integer('rate_id')->unsigned();
            $table->decimal('value', 15)->default(0);
            $table->primary(['customer_id', 'rate_id'], 'customer_rate');
        });
    }

    public function down()
    {
        Schema::dropIfExists('herzgarlan_config_customers');
        Schema::dropIfExists('herzgarlan_config_customers_rates');
    }

}
