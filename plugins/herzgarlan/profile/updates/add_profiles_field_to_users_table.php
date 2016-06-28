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
                'shipping_addr',
                'backend_user_id'
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
            $table->integer('backend_user_id')->unsigned(false);
        });
    }
    
    public function down()
    {
        if ( !Schema::hasColumns('users',[
                'company',
                'contact_no',
                'registration_no',
                'mailing_addr',
                'shipping_addr',
                'backend_user_id'
        ])) {
            return;
        }

        Schema::table('users', function($table)
        {
            $table->dropColumn('company');
            $table->dropColumn('contact_no');
            $table->dropColumn('registration_no');
            $table->dropColumn('mailing_addr');
            $table->dropColumn('shipping_addr');
            $table->dropColumn('backend_user_id');
        });
    }
}
