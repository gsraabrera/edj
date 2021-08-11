<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewerRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewer_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_id')->nullable();
            $table->string('q1')->nullable();
            $table->string('q2')->nullable();
            $table->string('q3')->nullable();
            $table->string('q4')->nullable();
            $table->string('q5')->nullable();
            $table->string('q6')->nullable();
            $table->string('q7')->nullable();
            $table->string('q8')->nullable();
            $table->string('q9')->nullable();
            $table->string('q10')->nullable();
            $table->string('q11')->nullable();
            $table->string('q12')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('markup_document')->nullable();
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
        Schema::dropIfExists('reviewer_recommendations');
    }
}
