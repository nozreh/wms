<?php namespace HerzGarlan\Inventory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanInventoryProductMovement extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_inventory_product_movement', function($table)
        {
            $table->text('before_loose_carton')->nullable();
            $table->text('after_loose_carton')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_inventory_product_movement', function($table)
        {
            $table->dropColumn('before_loose_carton');
            $table->dropColumn('after_loose_carton');
        });
    }
}
