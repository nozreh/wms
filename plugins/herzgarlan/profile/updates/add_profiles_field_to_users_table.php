<?php namespace HerzGarlan\Profile\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddProfilesFieldToUsersTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumns('users',[
                'company',
                'contact_no',
                'registration_no',
                'mailing_addr',
                'shipping_addr'
        ])) {
            return;
        }
        
        Schema::table('users', function($table)
        {
            $table->string('company')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->text('mailing_addr')->nullable();
            $table->text('shipping_addr')->nullable();
        });
    }
    
    public function down()
    {
         //Schema::dropIfExists('herzgarlan_profile_profiles');
    }
}
