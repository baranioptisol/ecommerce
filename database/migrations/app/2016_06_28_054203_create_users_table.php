<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users'))
        {
            Schema::create('users', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('username',120);
                $table->string('password');
                $table->string('email');
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
        Schema::drop('users');
    }
}
