<?php namespace HerzGarlan\Profile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanProfileProfiles extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_profile_profiles', function($table)
        {
            $table->string('contact_name')->nullable();
            $table->integer('contact_email')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_profile_profiles', function($table)
        {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_email');
        });
    }
}
