<?php namespace HerzGarlan\Inventory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanInventoryProducts extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_inventory_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->string('dimension')->nullable();
            $table->smallInteger('carton_quantity')->unsigned();
            $table->smallInteger('unit_quantity')->unsigned();
            $table->text('barcode')->nullable();
            $table->string('additional_info')->nullable();
            $table->decimal('weight', 10, 0)->nullable();
            $table->text('photo')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_inventory_products');
    }
}
