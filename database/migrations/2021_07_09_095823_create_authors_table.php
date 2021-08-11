<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
            ->constrained('articles')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string("email");
            $table->string("first_name");
            $table->string("middle_name");
            $table->string("last_name");
            $table->string("title")->nullable();
            $table->string("type");
            $table->boolean("corresponding_author");
            $table->string("office_contact_no")->nullable();
            $table->string("mobile_no")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
