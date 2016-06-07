<?php namespace HerzGarlan\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanJobsDeliveryOrderLog extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_jobs_delivery_order_log', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('delivery_order_id')->unsigned();
            $table->string('status')->default('Pending');
            $table->string('sub_status')->default('None');
            $table->text('remarks')->nullable();
            $table->integer('backend_user_id')->unsigned()->default(0);
            $table->integer('customer_id')->unsigned()->default(0);
            $table->integer('driver_id')->unsigned();
            $table->timestamp('created_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_jobs_delivery_order_log');
    }
}
