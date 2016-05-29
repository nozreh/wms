<?php namespace HerzGarlan\Jobs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanJobsDeliveryOrder extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_jobs_delivery_order', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id')->nullable()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->integer('backend_user_id')->unsigned()->default(0);
            $table->timestamp('order_date');
            $table->text('addr_from')->nullable();
            $table->text('addr_to')->nullable();
            $table->string('dimension');
            $table->string('weight');
            $table->text('product_info')->nullable();
            $table->string('tracking_no');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_jobs_delivery_order');
    }
}
