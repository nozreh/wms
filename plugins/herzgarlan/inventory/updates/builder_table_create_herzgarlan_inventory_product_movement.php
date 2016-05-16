<?php namespace HerzGarlan\Inventory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanInventoryProductMovement extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_inventory_product_movement', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('reason')->nullable();
            $table->smallInteger('before_carton')->unsigned();
            $table->smallInteger('after_carton')->unsigned();
            $table->smallInteger('before_unit')->unsigned();
            $table->smallInteger('after_unit')->unsigned();
            $table->integer('backend_user_id');
            $table->timestamp('created_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_inventory_product_movement');
    }
}
