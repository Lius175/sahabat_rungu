<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('questions');  // Storing questions as JSON
            $table->json('videos');     // Storing videos as JSON
            $table->json('options_1');  // Storing option 1 as JSON
            $table->json('options_2');  // Storing option 2 as JSON
            $table->json('options_3');  // Storing option 3 as JSON
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
        Schema::dropIfExists('quiz');
    }
}
