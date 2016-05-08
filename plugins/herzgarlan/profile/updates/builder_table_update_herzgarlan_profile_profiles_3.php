<?php namespace HerzGarlan\Profile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanProfileProfiles3 extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_profile_profiles', function($table)
        {
            $table->string('contact_email', 255)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_profile_profiles', function($table)
        {
            $table->integer('contact_email')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
