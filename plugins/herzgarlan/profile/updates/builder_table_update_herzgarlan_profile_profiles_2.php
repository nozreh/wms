<?php namespace HerzGarlan\Profile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHerzgarlanProfileProfiles2 extends Migration
{
    public function up()
    {
        Schema::table('herzgarlan_profile_profiles', function($table)
        {
            $table->integer('user_id')->unsigned()->index();
            $table->text('mailing_addr')->nullable()->unsigned(false)->default(null)->change();
            $table->text('shipping_addr')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('herzgarlan_profile_profiles', function($table)
        {
            $table->dropColumn('user_id');
            $table->string('mailing_addr', 255)->nullable()->unsigned(false)->default(null)->change();
            $table->string('shipping_addr', 255)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
