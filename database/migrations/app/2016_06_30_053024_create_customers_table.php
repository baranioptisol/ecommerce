<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('customers'))
        {
            
            Schema::create('customers', function(Blueprint $table) {
                 $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('username',120);
                $table->string('name',120);
                $table->string('company',120);
                $table->string('street_no',200);
                $table->string('street1',200);
                $table->string('street2',200);
                $table->string('city',120);
                $table->string('state',120);
                $table->string('zip',120);
                $table->string('country',120);
                $table->string('is_residential',120);
                $table->string('password');
                $table->string('email');
                $table->string('telephone');
                $table->string('object_purpose');
                $table->boolean('is_active')->default(1);  
                $table->boolean('is_deleted')->default(0); 
                $table->integer('created_by')->unsigned(); 
                $table->integer('updated_by')->unsigned();           
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
