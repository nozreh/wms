<?php namespace HerzGarlan\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanJobsDeliveryOrderRates extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_jobs_delivery_order_rates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('delivery_order_id')->unsigned();
            $table->integer('rate_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_jobs_delivery_order_rates');
    }
}
