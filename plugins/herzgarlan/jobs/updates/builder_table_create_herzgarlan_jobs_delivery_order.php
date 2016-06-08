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
            $table->integer('postal_from')->unsigned();
            $table->text('addr_to')->nullable();
            $table->integer('postal_to')->unsigned();
            $table->string('dimension');
            $table->string('weight');
            $table->string('status')->default('Pending');
            $table->string('sub_status')->nullable();
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
