<?php namespace HerzGarlan\Profile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHerzgarlanProfileProfiles extends Migration
{
    public function up()
    {
        Schema::create('herzgarlan_profile_profiles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('company')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('mailing_addr')->nullable();
            $table->string('zip')->nullable();
            $table->string('shipping_addr')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('herzgarlan_profile_profiles');
    }
}
