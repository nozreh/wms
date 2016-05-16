<?php namespace HerzGarlan\Config\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanConfigRates extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_config_rates', function($table)
        {
            $table->string('operator')->nullable();
            $table->renameColumn('updated_by', 'backend_user_id');
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_config_rates', function($table)
        {
            $table->dropColumn('operator');
            $table->renameColumn('backend_user_id', 'updated_by');
        });
    }
}
