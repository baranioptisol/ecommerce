<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('password_resets'))
        {
            Schema::create('password_resets', function (Blueprint $table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('email')->index();
                $table->string('token')->index();
                $table->timestamp('created_at');
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
        //
    }
}
