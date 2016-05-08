<?php namespace HerzGarlan\Inventory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanInventoryProducts extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_inventory_products', function($table)
        {
            $table->text('loose_carton');
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_inventory_products', function($table)
        {
            $table->dropColumn('loose_carton');
        });
    }
}
