<?php namespace HerzGarlan\Inventory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanInventoryProducts2 extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_inventory_products', function($table)
        {
            $table->string('weight')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_inventory_products', function($table)
        {
            $table->decimal('weight', 10, 0)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
