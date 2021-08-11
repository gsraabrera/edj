<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishedArticleAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('published_article_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('published_article_id')
            ->constrained('published_articles')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string("first_name");
            $table->string("middle_name");
            $table->string("last_name");
            $table->string("type");
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
        Schema::dropIfExists('published_article_authors');
    }
}
