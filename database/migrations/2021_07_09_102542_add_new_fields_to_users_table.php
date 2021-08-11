<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('title');
            $table->string('current_job_title');
            $table->string('department_research_unit');
            $table->string('institution');
            $table->string('street');
            $table->string('town');
            $table->string('zip');
            $table->string('country');
            $table->string('contact_no')->nullable();
            $table->string('mobile_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
