<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditorInChiefDecisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editor_in_chief_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
            ->constrained('articles')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('comment')->nullable();
            $table->string('recommendation_file')->nullable();
            $table->string('reviewed_file')->nullable();
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
        Schema::dropIfExists('editor_in_chief_decisions');
    }
}
