<?php namespace HerzGarlan\Inventory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanInventoryProduct extends Migration
{
    public function up()
    {
        Schema::rename('herzgarlan_inventory_products', 'herzgarlan_inventory_product');
    }
    
    public function down()
    {
        Schema::rename('herzgarlan_inventory_product', 'herzgarlan_inventory_products');
    }
}
