<?php namespace HerzGarlan\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanUsersDrivers extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_users_drivers', function($table)
        {
            $table->text('remarks')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_users_drivers', function($table)
        {
            $table->dropColumn('remarks');
        });
    }
}
